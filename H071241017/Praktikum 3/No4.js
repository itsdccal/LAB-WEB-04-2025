const readline = require("readline");

const rl3 = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

function tebak() {
  rl3.question("Masukkan salah satu dari angka 1 sampai 100: ", (input) => {
    if (isNaN(input)) {
      console.log("Harus angka!");
      return tebak();
    }

    const guess = Number(input);
    attempts++;

    if (guess > target) {
      console.log("Terlalu tinggi! Coba lagi.");
      tebak();
    } else if (guess < target) {
      console.log("Terlalu rendah! Coba lagi.");
      tebak();
    } else {
      console.log(`Selamat! kamu berhasil menebak angka ${target} dengan benar.`);
      console.log(`Sebanyak ${attempts}x percobaan.`);
      rl3.close();
    }
  });
}

tebak();
