const readline = require("readline");

const rl2 = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const hari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl2.question("Masukkan hari: ", (hariSekarang) => {
  const indexHari = hari.indexOf(hariSekarang.toLowerCase());

  if (indexHari === -1) {
    console.log("Hari tidak valid! Gunakan format: senin, selasa, dll.");
    rl2.close();
    return;
  }

  rl2.question("Masukkan jumlah hari ke depan: ", (jumlah) => {
    if (isNaN(jumlah)) {
      console.log("Jumlah hari harus berupa angka!");
      rl2.close();
      return;
    }

    const hasil = hari[(indexHari + Number(jumlah)) % 7];
    console.log(`${jumlah} hari setelah ${hariSekarang} adalah ${hasil}`);
    rl2.close();
  });
});
