const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

// no 3

const hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

function hitungHari(hariIni, JumlahHariTarget) {
    let indeksHariIni = hari.indexOf(hariIni.toLowerCase());
    if (indeksHariIni === -1) {
        return "Hari tidak valid. Masukkan hari dalam bahasa Indonesia (misal: senin).";
    }
    // Pastikan JumlahHariTarget adalah integer
    let indeksHariTarget = (indeksHariIni + parseInt(JumlahHariTarget)) % 7;
    return `${JumlahHariTarget} hari ke depan adalah hari ${hari[indeksHariTarget]}`;
}

rl.question("Masukkan hari ini: ", (hariInput) => {
    rl.question("Masukkan jumlah hari: ", (jumlahHariInput) => {
        console.log(hitungHari(hariInput, jumlahHariInput));
        
        rl.close();
    });
});