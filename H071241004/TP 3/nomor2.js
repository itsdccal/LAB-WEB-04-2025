const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Masukkan harga barang: ', (hargaInput) => {
  const harga = parseFloat(hargaInput);

  if (isNaN(harga)) {
    console.log('Error: Harga yang dimasukkan harus berupa angka.');
    rl.close();
    return;
  }

  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenisInput) => {
    const jenis = jenisInput.trim().toLowerCase();
    let diskonPersen = 0;

    switch (jenis) {
      case 'elektronik':
        diskonPersen = 10;
        break;
      case 'pakaian':
        diskonPersen = 20;
        break;
      case 'makanan':
        diskonPersen = 5;
        break;
      default:
        diskonPersen = 0;
        break;
    }

    const nilaiDiskon = harga * (diskonPersen / 100);
    const hargaAkhir = harga - nilaiDiskon;

    console.log(`\nHarga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskonPersen}%`);
    console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

    rl.close();
  });
});