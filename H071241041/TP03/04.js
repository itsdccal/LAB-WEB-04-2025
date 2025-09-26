/*
Kamu diminta untuk membuat permainan di mana komputer secara acak memilih sebuah angka antara 1 dan 100. 
Pemain harus menebak angka tersebut. Setiap kali pemain memberikan tebakan, komputer memberikan petunjuk 
apakah angka yang dipilih terlalu tinggi atau terlalu rendah. Permainan berlanjut sampai pemain menebak 
angka yang benar. Program harus menghitung jumlah tebakan yang diperlukan dan menampilkan hasilnya.
*/
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

let angka = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

function tanyaTebakan() {
  rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (input) => {
    let tebakan = parseInt(input);

    if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
      console.log("Input harus berupa angka antara 1 dan 100!");
      tanyaTebakan();
      return;
    }

    percobaan++;

    if (tebakan < angka) {
      console.log("Terlalu rendah! Coba lagi.");
      tanyaTebakan();
    } else if (tebakan > angka) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanyaTebakan();
    } else {
      console.log(`Selamat! kamu berhasil menebak angka ${angka} dengan benar.`);
      console.log(`Sebanyak ${percobaan}x percobaan.`);
      rl.close();
    }
  });
}

tanyaTebakan();
