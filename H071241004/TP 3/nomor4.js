const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;

console.log("Permainan Tebak Angka!");
console.log("Komputer telah memilih sebuah angka antara 1 dan 100. Coba tebak!");

function mulaiTebak() {
  rl.question('Masukkan tebakan Anda: ', (jawaban) => {
    const tebakan = parseInt(jawaban, 10);
    jumlahTebakan++;

    if (isNaN(tebakan)) {
      console.log('Input tidak valid. Harap masukkan angka.');
      mulaiTebak();
      return;
    }

    if (tebakan > angkaRahasia) {
      console.log('Terlalu tinggi! Coba lagi.');
      mulaiTebak();
    } else if (tebakan < angkaRahasia) {
      console.log('Terlalu rendah! Coba lagi.');
      mulaiTebak();
    } else {
      console.log(`\nSelamat! Kamu berhasil menebak angka ${angkaRahasia} dengan benar.`);
      console.log(`Sebanyak ${jumlahTebakan}x percobaan.`);
      rl.close();
    }
  });
}

mulaiTebak();