const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function hitungDiskon(harga, jenis) {
  let diskon = 0;

  switch (jenis.toLowerCase()) {
    case "elektronik":
      diskon = 0.1;
      break;
    case "pakaian":
      diskon = 0.2;
      break;
    case "makanan":
      diskon = 0.05;
      break;
    default:
      diskon = 0;
  }

  const hargaDiskon = harga - (harga * diskon);
  return { diskon: diskon * 100, hargaDiskon };
}

rl.question("Masukkan harga barang: ", (harga) => {
  if (isNaN(harga)) {
    console.log("Input harga harus berupa angka!");
    rl.close();
    return;
  }

  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
    const { diskon, hargaDiskon } = hitungDiskon(Number(harga), jenis);
    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon}%`);
    console.log(`Harga setelah diskon: Rp ${hargaDiskon}`);
    rl.close();
  });
});