// script.js (Versi Stabil - Perbaikan Bug Kartu +4)

// --- Data Kartu ---
const COLORS = ["red", "blue", "green", "yellow"];
const VALUES = [
  "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "skip", "reverse", "plus2",
];

function createDeck() {
  let deck = [];
  for (const color of COLORS) {
    deck.push({ color, value: "0", image: `${color}_0.png` });
    for (let i = 1; i <= 9; i++) {
      deck.push({ color, value: `${i}`, image: `${color}_${i}.png` });
      deck.push({ color, value: `${i}`, image: `${color}_${i}.png` });
    }
    ["skip", "reverse", "plus2"].forEach(value => {
      deck.push({ color, value, image: `${color}_${value}.png` });
      deck.push({ color, value, image: `${color}_${value}.png` });
    });
  }
  for (let i = 0; i < 4; i++) {
    deck.push({ color: "wild", value: "wild", image: "wild.png" });
    deck.push({ color: "wild", value: "plus4", image: "plus_4.png" });
  }
  return deck;
}

// --- State Permainan ---
let gameDeck = [], playerHand = [], botHand = [], discardPile = [];
let currentPlayer = "player", playerBalance = 5000, currentBet = 0;
let isBettingPhase = true, unoButtonTimer = null, unoButtonActive = false, hasDrawnCardThisTurn = false;

// --- Elemen DOM ---
const playerHandEl = document.getElementById("player-hand");
const botHandEl = document.getElementById("bot-hand");
const deckEl = document.getElementById("deck");
const discardPileEl = document.getElementById("discard-pile");
const gameStatusEl = document.getElementById("game-status");
const unoButtonEl = document.getElementById("uno-button");
const unoButtonContainerEl = document.querySelector(".uno-button-container");
const playerCardCountEl = document.getElementById("player-card-count");
const botCardCountEl = document.getElementById("bot-card-count");
const playerBalanceDisplayEl = document.getElementById("player-balance-display");
const currentBetDisplayEl = document.getElementById("current-bet-display");
const bettingAreaEl = document.getElementById("betting-area");
const betInputEl = document.getElementById("bet-input");
const placeBetButtonEl = document.getElementById("place-bet-button");
const wildColorsEl = document.getElementById("wild-colors");
const gameOverModalEl = document.getElementById("game-over-modal");
const gameOverTitleEl = document.getElementById("game-over-title");
const gameOverMessageEl = document.getElementById("game-over-message");
const restartButtonEl = document.getElementById("restart-button");
const colorIndicatorEl = document.getElementById("color-indicator");

// --- Fungsi Helper ---
function shuffleDeck(deck) {
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

function dealCards() {
  playerHand = [], botHand = [], discardPile = [];
  gameDeck = createDeck();
  shuffleDeck(gameDeck);

  for (let i = 0; i < 7; i++) {
    playerHand.push(gameDeck.pop());
    botHand.push(gameDeck.pop());
  }
  
  let startCard = gameDeck.pop();
  while (
    !startCard || ["skip", "reverse", "plus2", "wild", "plus4"].includes(startCard.value)
  ) {
    if (startCard) gameDeck.push(startCard);
    shuffleDeck(gameDeck);
    startCard = gameDeck.pop();
  }
  discardPile.push(startCard);
}

// --- Fungsi Update Tampilan (UI) ---
function updateColorIndicator(color) {
    const colorHexMap = { red: '#dc2626', blue: '#2563eb', green: '#16a34a', yellow: '#facc15', wild: '#f9fafb' };
    colorIndicatorEl.style.backgroundColor = colorHexMap[color] || 'transparent';
    colorIndicatorEl.style.borderColor = colorHexMap[color] || '#6b7280';
}

function updateUI() {
  renderHands();
  const topCard = discardPile[discardPile.length - 1];
  if (topCard) {
      discardPileEl.style.backgroundImage = `url('kartu/${topCard.image}')`;
      updateColorIndicator(topCard.color);
  } else {
      discardPileEl.style.backgroundImage = '';
      updateColorIndicator('transparent');
  }
  playerCardCountEl.textContent = playerHand.length;
  botCardCountEl.textContent = botHand.length;
  playerBalanceDisplayEl.textContent = `Saldo: $${playerBalance}`;
  currentBetDisplayEl.textContent = currentBet;
}

function renderHands() {
  playerHandEl.innerHTML = "";
  playerHand.forEach(card => {
    const cardEl = document.createElement("div");
    cardEl.className = "card card-player";
    cardEl.style.backgroundImage = `url('kartu/${card.image}')`;
    cardEl.dataset.color = card.color;
    cardEl.dataset.value = card.value;
    playerHandEl.appendChild(cardEl);
  });
  botHandEl.innerHTML = "";
  botHand.forEach(() => {
    const cardEl = document.createElement("div");
    cardEl.className = "card card-bot";
    cardEl.style.backgroundImage = `url('kartu/card_back.png')`;
    botHandEl.appendChild(cardEl);
  });
}

// --- Logika Inti Permainan ---
function canPlayCard(card) {
  const topCard = discardPile[discardPile.length - 1];
  if (!topCard || card.color === "wild") return true;
  return card.color === topCard.color || card.value === topCard.value;
}

function checkWin() {
  if (playerHand.length === 0 || botHand.length === 0) {
    gameOver(playerHand.length === 0);
    return true;
  }
  return false;
}

function switchTurn() {
  currentPlayer = (currentPlayer === "player") ? "bot" : "player";
  hasDrawnCardThisTurn = false;
  gameStatusEl.textContent = (currentPlayer === "player") ? "Giliran Anda." : "Giliran Bot...";
  if (currentPlayer === "bot") setTimeout(handleBotTurn, 1500);
}

function handleCardPlay(card, player) {
    const hand = (player === "player") ? playerHand : botHand;
    const cardIndex = hand.findIndex(c => c.color === card.color && c.value === card.value);
    if (cardIndex === -1) return;

    const [playedCard] = hand.splice(cardIndex, 1);
    discardPile.push(playedCard);

    if (player === "player" && hand.length === 1) startUnoTimer();
    else clearUnoTimer();

    updateUI();
    if (checkWin()) return;

    const isPlayerMove = player === 'player';
    if (playedCard.value === 'skip') {
        gameStatusEl.textContent = `Kartu Skip! Giliran lawan dilewati.`;
        // Dalam 2 pemain, skip berarti pemain yang sama main lagi
        if (isPlayerMove) hasDrawnCardThisTurn = false;
        else setTimeout(handleBotTurn, 1500);
    } else if (playedCard.value === 'reverse' || playedCard.value === 'plus2') {
        const actor = isPlayerMove ? 'Anda' : 'Bot';
        const target = isPlayerMove ? 'Bot' : 'Anda';
        if (playedCard.value === 'plus2') {
            drawCards(isPlayerMove ? botHand : playerHand, 2);
            gameStatusEl.textContent = `Kartu +2! ${target} mengambil 2 kartu. Giliran ${actor} lagi.`;
        } else {
            gameStatusEl.textContent = `Arah permainan dibalik! Giliran ${actor} lagi.`;
        }
        if (isPlayerMove) hasDrawnCardThisTurn = false;
        else setTimeout(handleBotTurn, 1500);
    } else if (playedCard.color === 'wild') {
        if (isPlayerMove) {
            showWildColorPicker(playedCard);
        } else { // Bot memainkan kartu Wild
            const newColor = COLORS[Math.floor(Math.random() * COLORS.length)];
            discardPile[discardPile.length - 1].color = newColor;
            gameStatusEl.textContent = `Bot memainkan Wild. Warna jadi ${newColor.toUpperCase()}.`;
            updateColorIndicator(newColor);
            
            if (playedCard.value === 'plus4') {
                gameStatusEl.textContent += " Anda mengambil 4 kartu. Giliran Bot lagi.";
                drawCards(playerHand, 4);
                setTimeout(handleBotTurn, 1500); // Bot main lagi
            } else {
                switchTurn(); // Giliran normal ke pemain
            }
        }
    } else {
        switchTurn(); // Kartu angka biasa
    }
}

function drawCards(hand, num) {
  for (let i = 0; i < num; i++) {
    if (gameDeck.length === 0) {
      if (discardPile.length <= 1) break;
      const topCard = discardPile.pop();
      gameDeck = discardPile.splice(0);
      shuffleDeck(gameDeck);
      discardPile.push(topCard);
    }
    if (gameDeck.length > 0) hand.push(gameDeck.pop());
  }
  updateUI();
}

function handleBotTurn() {
  const playableCards = botHand.filter(card => canPlayCard(card));
  const actionCards = playableCards.filter(c => ["skip", "reverse", "plus2"].includes(c.value));
  const wildPlus4 = botHand.find(c => c.value === 'plus4');
  let cardToPlay = actionCards[0] || playableCards[0] || (wildPlus4 && !playableCards.length ? wildPlus4 : null);

  if (cardToPlay) {
    handleCardPlay(cardToPlay, "bot");
  } else {
    drawCards(botHand, 1);
    const drawnCard = botHand[botHand.length - 1];
    if (drawnCard && canPlayCard(drawnCard)) {
      gameStatusEl.textContent = "Bot mengambil kartu dan langsung memainkannya.";
      setTimeout(() => handleCardPlay(drawnCard, "bot"), 1000);
    } else {
      gameStatusEl.textContent = "Bot mengambil kartu dan melewati giliran.";
      setTimeout(switchTurn, 1000);
    }
  }
  if (botHand.length === 1) setTimeout(() => gameStatusEl.textContent = "Bot teriak UNO!", 500);
}

function showWildColorPicker(card) {
  wildColorsEl.style.display = "flex";
  wildColorsEl.querySelectorAll("div").forEach(picker => {
    picker.onclick = () => {
      const newColor = picker.dataset.color;
      discardPile[discardPile.length - 1].color = newColor;
      wildColorsEl.style.display = "none";
      gameStatusEl.textContent = `Warna berubah menjadi ${newColor.toUpperCase()}.`;
      updateColorIndicator(newColor);
      if (checkWin()) return;

      if (card.value === "plus4") {
        gameStatusEl.textContent += " Bot mengambil 4 kartu. Giliran Anda lagi.";
        drawCards(botHand, 4);
        hasDrawnCardThisTurn = false; // Anda dapat giliran baru
      } else {
        switchTurn(); // Giliran normal ke bot
      }
    };
  });
}

function startUnoTimer() {
  unoButtonActive = true;
  unoButtonContainerEl.style.display = "block";
  gameStatusEl.textContent = "UNO! Tekan tombol UNO dalam 5 detik!";
  unoButtonTimer = setTimeout(() => {
    if (unoButtonActive) {
      gameStatusEl.textContent = "Terlambat bilang UNO! Penalti +2 kartu.";
      drawCards(playerHand, 2);
      clearUnoTimer();
    }
  }, 5000);
}

function clearUnoTimer() {
  clearTimeout(unoButtonTimer);
  unoButtonActive = false;
  unoButtonContainerEl.style.display = "none";
}

function gameOver(isPlayerWinner) {
  isBettingPhase = true;
  bettingAreaEl.style.display = "flex";
  playerBalance += isPlayerWinner ? currentBet : -currentBet;
  gameOverTitleEl.textContent = isPlayerWinner ? "Anda Menang!" : "Anda Kalah!";
  gameOverMessageEl.textContent = `Anda ${isPlayerWinner ? 'menang' : 'kalah'} $${currentBet}. Saldo baru: $${playerBalance}`;

  if (playerBalance <= 0) {
    gameOverTitleEl.textContent = "Game Over";
    gameOverMessageEl.textContent = "Saldo Anda habis. Mari coba lagi!";
    restartButtonEl.textContent = "Mulai Ulang Penuh";
  } else {
    restartButtonEl.textContent = "Main Ronde Berikutnya";
  }
  currentBet = 0;
  gameOverModalEl.classList.remove("hidden");
}

// --- Event Listeners ---
placeBetButtonEl.addEventListener("click", () => {
  const bet = parseInt(betInputEl.value);
  if (isNaN(bet) || bet < 100 || bet > playerBalance) {
    alert("Taruhan tidak valid. Minimal $100 dan tidak melebihi saldo.");
    return;
  }
  currentBet = bet;
  isBettingPhase = false;
  bettingAreaEl.style.display = "none";
  startGame();
});

deckEl.addEventListener("click", () => {
  if (currentPlayer !== "player" || hasDrawnCardThisTurn) return;
  if (playerHand.some(canPlayCard)) {
    gameStatusEl.textContent = "Anda masih punya kartu yang bisa dimainkan!";
    return;
  }
  drawCards(playerHand, 1);
  hasDrawnCardThisTurn = true;
  const drawnCard = playerHand[playerHand.length - 1];
  if (drawnCard && canPlayCard(drawnCard)) {
    gameStatusEl.textContent = "Anda mengambil kartu. Anda bisa memainkannya sekarang.";
  } else {
    gameStatusEl.textContent = "Kartu yang diambil tidak cocok. Giliran dilewati.";
    setTimeout(switchTurn, 1500);
  }
});

playerHandEl.addEventListener("click", (event) => {
  if (currentPlayer !== "player") return;
  const cardEl = event.target.closest(".card");
  if (!cardEl) return;
  const card = { color: cardEl.dataset.color, value: cardEl.dataset.value };
  
  if (card.value === "plus4" && playerHand.some(c => c.value !== 'plus4' && canPlayCard(c))) {
    gameStatusEl.textContent = "Tidak boleh main +4 jika punya kartu lain yang bisa dimainkan!";
    return;
  }
  if (canPlayCard(card)) handleCardPlay(card, "player");
  else gameStatusEl.textContent = "Kartu tidak cocok. Mainkan kartu lain atau ambil dari dek.";
});

unoButtonEl.addEventListener("click", () => {
  if (playerHand.length === 1 && unoButtonActive) {
    clearUnoTimer();
    gameStatusEl.textContent = "UNO! Anda aman dari penalti.";
  }
});

restartButtonEl.addEventListener("click", () => {
  gameOverModalEl.classList.add("hidden");
  if (playerBalance <= 0) playerBalance = 5000;
  bettingAreaEl.style.display = "flex";
  discardPile = [];
  playerHand = [];
  botHand = [];
  gameStatusEl.textContent = "Silakan pasang taruhan untuk ronde berikutnya.";
  updateUI();
});

// --- Inisialisasi Game ---
function startGame() {
  dealCards();
  currentPlayer = "player";
  hasDrawnCardThisTurn = false;
  gameStatusEl.textContent = "Giliran Anda. Mainkan kartu pertama.";
  updateUI();
}

// Mulai
gameStatusEl.textContent = "Selamat datang! Silakan pasang taruhan untuk memulai.";
updateUI(); 