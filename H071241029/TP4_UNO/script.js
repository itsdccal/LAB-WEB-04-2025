/* UNO Game - Perbaikan stacking rules (+2 / +4) dan draw otomatis */
/* Pastikan assets/ masih ada seperti sebelumnya */

const colors = ["red", "yellow", "green", "blue"];
let deck = [], player = [], bot = [], discard = [];
let saldo = 5000, taruhan = 100;
let currentPlayer = "player";
let warnaAktif = null;
let drawStack = 0;       // jumlah kartu yang harus diambil ketika stacking terjadi
let stackType = null;    // "+2" atau "+4" (jenis stacking aktif)
let waitingPlayChoice = false;
let playChoiceTimer = null;
let unoTimer = null;
let lastPlayedBy = null;
let playerHasPressedUno = false;
let botHasPressedUno = false;
let callUnoVisible = false;

const $ = id => document.getElementById(id);

// Rolling log (max 5)
function log(msg) {
  const l = $("log");
  const entry = document.createElement("p");
  entry.textContent = `${new Date().toLocaleTimeString()} - ${msg}`;
  l.appendChild(entry);
  const notes = l.querySelectorAll("p");
  if (notes.length > 5) l.removeChild(notes[0]);
  l.scrollTop = l.scrollHeight;
}

function setStatus(t) {
  $("statusBox").textContent = `Status: ${t}`;
}

// Deck creation & utils
function createDeck() {
  deck = [];
  for (const c of colors) {
    for (let n = 0; n <= 9; n++) deck.push({ color: c, value: n.toString(), image: `${c}_${n}.png` });
    deck.push({ color: c, value: "Reverse", image: `${c}_reverse.png` });
    deck.push({ color: c, value: "+2", image: `${c}_plus2.png` });
    deck.push({ color: c, value: "Skip", image: `${c}_skip.png` });
  }
  for (let i = 0; i < 4; i++) {
    deck.push({ color: "wild", value: "Wild", image: `wild.png` });
    deck.push({ color: "wild", value: "+4", image: `plus_4.png` });
  }
  shuffle(deck);
}

function shuffle(a) {
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
}

function reshuffleIfEmpty() {
  if (deck.length === 0) {
    const top = discard.pop();
    deck = discard.splice(0);
    discard = [top];
    shuffle(deck);
    log("🔄 Deck habis — discard dikocok ulang menjadi deck.");
  }
}

// START GAME
$("mulaiBtn").addEventListener("click", () => {
  taruhan = parseInt($("taruhan").value) || 100;
  if (taruhan < 100 || taruhan > saldo) { alert("Taruhan tidak valid!"); return; }
  createDeck();
  player = deck.splice(0, 7);
  bot = deck.splice(0, 7);
  discard = [deck.pop()];
  warnaAktif = discard[0].color === "wild" ? null : discard[0].color;
  currentPlayer = "player";
  drawStack = 0;
  stackType = null;
  playerHasPressedUno = false;
  botHasPressedUno = false;
  $("gameArea").classList.remove("hidden");
  $("callUnoBtn").classList.add("hidden");
  callUnoVisible = false;
  updateDisplay();
  log("🎮 Game dimulai! Giliranmu.");
  setStatus("Giliranmu");
});

// DISPLAY (termasuk tombol call UNO)
function updateDisplay() {
  $("saldo").textContent = saldo;

  $("playerCards").innerHTML = player.map(
    (c, i) => `<div class="player-card" title="${c.color} ${c.value}" onclick="playerPlay(${i})"><img src="assets/${c.image}" /></div>`
  ).join("");

  $("botCards").innerHTML = `<img class="back-card" src="assets/card_back.png" />`.repeat(bot.length);

  const top = discard[discard.length - 1];
  $("discardPile").innerHTML = `<img src="assets/${top.image}" />`;
  $("deck").innerHTML = `<img src="assets/card_back.png" />`;

  // tampilkan / sembunyikan tombol panggil UNO lawan
  const callUnoBtn = $("callUnoBtn");
  if (bot.length === 1 && !callUnoVisible) {
    callUnoBtn.classList.remove("hidden");
    // kasih efek glow sebentar
    callUnoBtn.classList.add("glow");
    setTimeout(() => callUnoBtn.classList.remove("glow"), 1200);
    callUnoVisible = true;
  } else if (bot.length !== 1 && callUnoVisible) {
    callUnoBtn.classList.add("hidden");
    callUnoVisible = false;
  }
}

// Valid play: jika ada drawStack, hanya kartu sejenis stackType yang boleh dipakai
function isPlayable(card, top) {
  if (drawStack > 0) {
    // hanya boleh stack kartu dengan jenis yang sama
    return card.value === stackType;
  }
  if (warnaAktif && card.color === warnaAktif) return true;
  if (card.color === top.color) return true;
  if (card.value === top.value) return true;
  if (card.color === "wild") return true;
  return false;
}

// check +4 rule: apakah pemain/bot memiliki kartu lain yang bisa dimainkan (bukan +4)
function hasOtherPlayableExceptPlus4(hand, top) {
  for (const c of hand) {
    if (c.value === "+4") continue;
    if (isPlayable(c, top) && c.color !== "wild") return true;
  }
  return false;
}

function hasStackInHand(hand) {
  if (!stackType) return false;
  return hand.some(c => c.value === stackType);
}

// PLAYER ACTIONS
function playerPlay(index) {
  if (currentPlayer !== "player") { log("Bukan giliranmu."); return; }

  // Jika ada drawStack aktif, cek apakah pemain harus otomatis mengambil jika tak punya stack type
  if (drawStack > 0) {
    if (!hasStackInHand(player)) {
      // tidak punya kartu sejenis => otomatis ambil
      log(`📥 Kamu tidak punya ${stackType} — otomatis mengambil ${drawStack} kartu.`);
      takeCards(player, drawStack);
      drawStack = 0;
      stackType = null;
      updateDisplay();
      // giliran ke bot
      currentPlayer = "bot";
      setTimeout(botTurn, 900);
      return;
    }
    // kalau punya stackType, lanjut normal: pemain bisa pilih untuk tumpuk
  }

  const card = player[index];
  const top = discard[discard.length - 1];

  if (!isPlayable(card, top)) { log("Kartu tidak bisa dimainkan."); return; }

  // +4 specific check
  if (card.value === "+4" && hasOtherPlayableExceptPlus4(player, top)) {
    log("⚠️ Tidak boleh mainkan +4 jika masih punya kartu lain yang bisa dimainkan.");
    return;
  }

  // mainkan kartu
  player.splice(index, 1);
  discard.push(card);
  lastPlayedBy = "player";
  log(`🃏 Kamu memainkan ${card.color} ${card.value}`);
  if (card.color !== "wild") warnaAktif = card.color;

  // aksi khusus
  if (card.value === "+2") {
    // mulai atau lanjut stacking +2
    if (!stackType) stackType = "+2";
    drawStack += 2;
    currentPlayer = "bot";
    setTimeout(botTurn, 900);
    updateDisplay();
    return;
  } else if (card.value === "+4") {
    if (!stackType) stackType = "+4";
    drawStack += 4;
    // pilih warna dulu
    showColorModal(() => {
      log(`🎨 Kamu memilih warna ${warnaAktif.toUpperCase()}`);
      currentPlayer = "bot";
      setTimeout(botTurn, 900);
    });
    updateDisplay();
    return;
  } else if (card.value === "Wild") {
    showColorModal(() => {
      log(`🎨 Kamu memilih warna ${warnaAktif.toUpperCase()}`);
      currentPlayer = "bot";
      setTimeout(botTurn, 900);
    });
    updateDisplay();
    return;
  } else if (card.value === "Skip" || card.value === "Reverse") {
    // untuk 2 pemain, Reverse = Skip
    log("➡️ Lawan dilewati.");
    updateDisplay();
    // skip bot once
    setTimeout(() => botTurn(true), 900);
    return;
  } else {
    // biasa
    currentPlayer = "bot";
    setStatus("Giliran Bot");
    updateDisplay();
    setTimeout(botTurn, 900);
  }

  // UNO check
  if (player.length === 1) {
    $("unoBtn").disabled = false;
    playerHasPressedUno = false;
    if (unoTimer) clearTimeout(unoTimer);
    unoTimer = setTimeout(() => {
      if (!playerHasPressedUno) {
        log("❌ Lupa tekan UNO! Penalti +2 kartu.");
        takeCards(player, 2);
        updateDisplay();
      }
      $("unoBtn").disabled = true;
    }, 5000);
  }

  if (player.length === 0) endRound(true);
}

// If player clicks deck to draw (normal draw)
function playerDrawFromDeck() {
  if (currentPlayer !== "player") return;

  // jika ada drawStack, cek apakah pemain bisa stack; jika tidak, wajib ambil drawStack
  if (drawStack > 0) {
    if (hasStackInHand(player)) {
      log(`⚠️ Kamu masih bisa menumpuk ${stackType}. Mainkan atau kamu akan mengambil ${drawStack} kartu.`);
      return;
    } else {
      log(`📥 Kamu mengambil ${drawStack} kartu karena efek ${stackType}.`);
      takeCards(player, drawStack);
      drawStack = 0;
      stackType = null;
      updateDisplay();
      currentPlayer = "bot";
      setTimeout(botTurn, 900);
      return;
    }
  }

  // normal draw
  reshuffleIfEmpty();
  const taken = deck.pop();
  player.push(taken);
  updateDisplay();
  log(`📥 Kamu mengambil 1 kartu (${taken.color} ${taken.value}).`);
  const top = discard[discard.length - 1];
  if (isPlayable(taken, top) || taken.color === "wild") {
    showPlayChoiceModal(taken);
  } else {
    currentPlayer = "bot";
    setTimeout(botTurn, 800);
  }
}

// play choice modal logic (same behavior as sebelumya)
function showPlayChoiceModal(taken) {
  waitingPlayChoice = true;
  $("playChoiceModal").classList.remove("hidden");
  let countdown = 8;
  const p = $("playChoiceModal").querySelector("p");
  p.textContent = `Mainkan kartu yang diambil atau lewati giliran? (${countdown}s)`;
  playChoiceTimer = setInterval(() => {
    countdown--;
    p.textContent = `Mainkan kartu yang diambil atau lewati giliran? (${countdown}s)`;
    if (countdown <= 0) {
      clearInterval(playChoiceTimer);
      $("playChoiceModal").classList.add("hidden");
      waitingPlayChoice = false;
      currentPlayer = "bot";
      setTimeout(botTurn, 700);
    }
  }, 1000);
}

function confirmPlayDrawn(play) {
  clearInterval(playChoiceTimer);
  $("playChoiceModal").classList.add("hidden");
  waitingPlayChoice = false;
  if (play) {
    const drawn = player[player.length - 1];
    const top = discard[discard.length - 1];
    if (isPlayable(drawn, top) || drawn.color === "wild") {
      // +4 restriction
      if (drawn.value === "+4" && hasOtherPlayableExceptPlus4(player, top)) {
        log("⚠️ +4 tidak dapat dimainkan (ada kartu lain yang bisa dimainkan). Lewati giliran.");
        currentPlayer = "bot";
        setTimeout(botTurn, 700);
        return;
      }
      player.pop();
      discard.push(drawn);
      log(`🃏 Kamu memainkan kartu yang diambil: ${drawn.color} ${drawn.value}`);
      if (drawn.color !== "wild") warnaAktif = drawn.color;
      if (drawn.value === "+2") {
        if (!stackType) stackType = "+2";
        drawStack += 2;
        currentPlayer = "bot";
        setTimeout(botTurn, 900);
        updateDisplay();
        return;
      }
      if (drawn.value === "+4") {
        if (!stackType) stackType = "+4";
        drawStack += 4;
        showColorModal(() => {
          log(`🎨 Kamu memilih warna ${warnaAktif.toUpperCase()}`);
          currentPlayer = "bot";
          setTimeout(botTurn, 900);
        });
        updateDisplay();
        return;
      }
      if (drawn.value === "Wild") {
        showColorModal(() => {
          log(`🎨 Kamu memilih warna ${warnaAktif.toUpperCase()}`);
          currentPlayer = "bot";
          setTimeout(botTurn, 900);
        });
        updateDisplay();
        return;
      }
      if (drawn.value === "Skip" || drawn.value === "Reverse") {
        setTimeout(() => botTurn(true), 900);
        return;
      }
      currentPlayer = "bot";
      setTimeout(botTurn, 700);
      return;
    }
  }
  currentPlayer = "bot";
  setTimeout(botTurn, 700);
}

// BOT logic (dengan perbaikan stacking)
function botTurn(skip = false) {
  if (skip) {
    log("🤖 Bot dilewati.");
    currentPlayer = "player";
    setStatus("Giliranmu");
    return;
  }

  const top = discard[discard.length - 1];

  // kalau ada drawStack, bot hanya boleh menumpuk dengan stackType
  if (drawStack > 0) {
    // cari kartu jenis stackType di tangan bot
    const stacking = bot.find(c => c.value === stackType);
    if (stacking) {
      // bot menumpuk
      bot.splice(bot.indexOf(stacking), 1);
      discard.push(stacking);
      log(`🤖 Bot menumpuk ${stacking.value} (${stacking.color}).`);
      // drawStack dan stackType sudah dikelola: tambah sesuai jenis
      if (!stackType) stackType = stacking.value; // safety (shouldn't happen)
      drawStack += (stacking.value === "+2") ? 2 : 4;
      currentPlayer = "player";
      updateDisplay();
      return;
    } else {
      // bot tidak punya kartu yang dapat menumpuk => bot harus mengambil drawStack
      log(`🤖 Bot tidak bisa menumpuk — mengambil ${drawStack} kartu.`);
      takeCards(bot, drawStack);
      drawStack = 0;
      stackType = null;
      currentPlayer = "player";
      updateDisplay();
      setStatus("Giliranmu");
      return;
    }
  }

  // normal playable logic (tidak ada drawStack)
  let playable = bot.filter(c => isPlayable(c, top) || c.color === "wild");

  if (playable.length > 0) {
    // prioritas: +4 > +2 > action > warna aktif > number
    let pick = playable.find(c => c.value === "+4") || playable.find(c => c.value === "+2") ||
      playable.find(c => c.value === "Skip") || playable.find(c => c.value === "Reverse") ||
      playable.find(c => c.color === warnaAktif) || playable[0];

    // +4 restriction: bot tidak boleh main +4 jika punya kartu lain playable
    if (pick.value === "+4") {
      if (hasOtherPlayableExceptPlus4(bot, top)) {
        const alt = bot.find(c => (c.value !== "+4") && (isPlayable(c, top) || (warnaAktif && c.color === warnaAktif)));
        if (alt) pick = alt;
      }
    }

    // play chosen card
    bot.splice(bot.indexOf(pick), 1);
    discard.push(pick);
    log(`🤖 Bot memainkan ${pick.color} ${pick.value}`);
    if (pick.color !== "wild") warnaAktif = pick.color;

    if (pick.value === "+2") {
      // mulai stacking +2
      stackType = "+2";
      drawStack += 2;
      currentPlayer = "player";
      updateDisplay();
      setStatus("Giliranmu (tumpukan +2)");
      return;
    } else if (pick.value === "+4") {
      stackType = "+4";
      drawStack += 4;
      warnaAktif = chooseBotColor();
      log(`🤖 Bot memilih warna ${warnaAktif.toUpperCase()}`);
      currentPlayer = "player";
      updateDisplay();
      setStatus("Giliranmu (tumpukan +4)");
      return;
    } else if (pick.value === "Wild") {
      warnaAktif = chooseBotColor();
      log(`🤖 Bot memilih warna ${warnaAktif.toUpperCase()}`);
      currentPlayer = "player";
      updateDisplay();
      setStatus("Giliranmu");
      return;
    } else if (pick.value === "Skip" || pick.value === "Reverse") {
      log("➡️ Kamu dilewati oleh Bot!");
      updateDisplay();
      setTimeout(() => botTurn(true), 900);
      return;
    } else {
      // normal
      currentPlayer = "player";
      updateDisplay();
      setStatus("Giliranmu");
      if (bot.length === 1) {
        setTimeout(() => { botHasPressedUno = true; log("🤖 Bot menekan UNO!"); }, 600);
      }
      if (bot.length === 0) endRound(false);
      return;
    }
  } else {
    // tidak ada yang bisa dimainkan
    reshuffleIfEmpty();
    bot.push(deck.pop());
    log("🤖 Bot mengambil 1 kartu.");
    currentPlayer = "player";
    setStatus("Giliranmu");
    updateDisplay();
    return;
  }
}

// Bot color choice heuristic
function chooseBotColor() {
  const counts = { red: 0, green: 0, blue: 0, yellow: 0 };
  for (const c of bot) if (colors.includes(c.color)) counts[c.color]++;
  let best = "red", max = -1;
  for (const col of colors) if (counts[col] > max) (max = counts[col], best = col);
  return best;
}

// Modal warna untuk player
function showColorModal(callback) {
  const modal = $("colorModal");
  modal.classList.remove("hidden");
  modal._cb = callback;
}
function chooseColor(col) {
  warnaAktif = col;
  $("colorModal").classList.add("hidden");
  log(`🎨 Warna dipilih: ${col.toUpperCase()}`);
  const modal = $("colorModal");
  if (modal._cb) { const cb = modal._cb; modal._cb = null; setTimeout(cb, 200); }
}

// UNO button
$("unoBtn").addEventListener("click", () => {
  if (currentPlayer === "player" && player.length === 1) {
    playerHasPressedUno = true;
    $("unoBtn").disabled = true;
    clearTimeout(unoTimer);
    log("✅ Kamu menekan UNO tepat waktu!");
  } else {
    log("UNO hanya bisa ditekan saat kamu tinggal 1 kartu.");
  }
});

// Call UNO button (panggil UNO lawan)
$("callUnoBtn").addEventListener("click", () => {
  if (bot.length === 1 && !botHasPressedUno) {
    log("🎯 Kamu memanggil UNO! Bot lupa — kena +2 kartu.");
    takeCards(bot, 2);
    updateDisplay();
  } else {
    log("Tidak bisa memanggil UNO sekarang.");
  }
});

// Helpers
function takeCards(hand, n) {
  for (let i = 0; i < n; i++) {
    reshuffleIfEmpty();
    hand.push(deck.pop());
  }
}

function endRound(playerWon) {
  if (playerWon) {
    saldo += taruhan;
    log(`🏆 Kamu menang! Saldo: ${saldo}`);
  } else {
    saldo -= taruhan;
    log(`💸 Kamu kalah. Saldo: ${saldo}`);
  }
  updateDisplay();
  if (saldo <= 0) { log("💀 Game over. Saldo habis."); $("mulaiBtn").disabled = true; return; }
  $("mulaiBtn").disabled = false;
  $("gameArea").classList.add("hidden");
}

// ensure modals hidden initially
window.onload = () => {
  $("colorModal").classList.add("hidden");
  $("playChoiceModal").classList.add("hidden");
  $("callUnoBtn").classList.add("hidden");
};
