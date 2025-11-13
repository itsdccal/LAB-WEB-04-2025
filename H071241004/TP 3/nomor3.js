const namaHari = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];

const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Masukkan hari saat ini: ', (hariIniInput) => {
  let hariIni = hariIniInput.trim().toLowerCase();
  const indeksHariIni = namaHari.indexOf(hariIni);

  if (indeksHariIni === -1) {
    console.log('Error: Nama hari tidak valid.');
    rl.close();
    return;
  }

  rl.question('Masukkan jumlah hari yang akan datang: ', (jumlahHariInput) => {
    const jumlahHari = parseInt(jumlahHariInput, 10);

    if (isNaN(jumlahHari)) {
      console.log('Error: Jumlah hari harus berupa angka.');
      rl.close();
      return;
    }

    const indeksHariNanti = (indeksHariIni + jumlahHari) % 7;
    const hariNanti = namaHari[indeksHariNanti];

    const hariNantiFormatted = hariNanti.charAt(0).toUpperCase() + hariNanti.slice(1);
    const hariIniFormatted = hariIni.charAt(0).toUpperCase() + hariIni.slice(1);

    console.log(`\n${jumlahHari} hari setelah ${hariIniFormatted} adalah ${hariNantiFormatted}`);
    rl.close();
  });
});