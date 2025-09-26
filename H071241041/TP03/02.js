/*
Buatlah sebuah program JavaScript yang menerima input harga barang dan jenis barang dari pengguna, 
kemudian menghitung harga akhir setelah menerapkan diskon. Diskon yang diberikan berbeda-beda tergantung 
pada jenis barang: 
● Elektronik: Diskon 10% 
● Pakaian: Diskon 20% 
● Makanan: Diskon 5% 
● Lainnya: Tidak ada diskon 
*/

const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question("Masukkan harga barang: ", (hargaInput) => {
  let harga = parseFloat(hargaInput);

  if (isNaN(harga) || harga <= 0) {
    console.log("Input harga harus berupa angka positif.");
    rl.close();
    return;
  }

  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
    jenis = jenis.toLowerCase();
    let diskon = 0;

    if (jenis === "elektronik") {
      diskon = 0.10;
    } else if (jenis === "pakaian") {
      diskon = 0.20;
    } else if (jenis === "makanan") {
      diskon = 0.05;
    }

    let potongan = harga * diskon;
    let total = harga - potongan;

    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${total}`);

    rl.close();
  });
});
