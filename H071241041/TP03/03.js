/*
Di sebuah dunia imajiner, kamu adalah seorang pengelola waktu yang bertugas untuk membantu 
para penduduk menentukan hari apa yang akan datang setelah sejumlah hari tertentu (mis. hari 
ini adalah hari Jum’at, maka 1000 hari yang akan datang adalah hari Kamis). Namun, karena peralatan 
canggih kamu sedang tidak berfungsi, kamu harus menggunakan metode manual tanpa menggunakan objek `Date` atau 
kalender apa pun. Kamu hanya diberikan sebuah array yang berisikan nama-nama hari dalam seminggu.
*/
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

let hari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl.question("Masukkan hari: ", (hariInput) => {
  let hariAwal = hariInput.toLowerCase();

  if (!hari.includes(hariAwal)) {
    console.log("Hari tidak valid!");
    rl.close();
    return;
  }

  rl.question("Masukkan jumlah hari ke depan: ", (jumlahInput) => {
    let jumlah = parseInt(jumlahInput);

    if (isNaN(jumlah) || jumlah < 0) {
      console.log("Input jumlah hari harus berupa angka non-negatif.");
      rl.close();
      return;
    }

    let indexAwal = hari.indexOf(hariAwal);
    let indexHasil = (indexAwal + jumlah) % 7;

    console.log(`${jumlah} hari setelah ${hariAwal} adalah ${hari[indexHasil]}`);
    rl.close();
  });
});
