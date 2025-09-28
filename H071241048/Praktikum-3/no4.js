const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

// no 4


const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahPercobaan = 0;

console.log("aku telah memilih sebuah angka antara 1-100. coba tebak!");

function tebakAngka() {
    rl.question("Masukkan tebakanmu: ", (tebakan) => {
        const tebakanAngka = parseInt(tebakan);
        jumlahPercobaan++;

        if (isNaN(tebakanAngka)) {
            console.log("Input tidak valid, silakan masukkan angka.");
            tebakAngka();
        } else if (tebakanAngka > angkaRahasia) {
            console.log("Terlalu tinggi!");
            tebakAngka(); 
        } else if (tebakanAngka < angkaRahasia) {
            console.log("Terlalu rendah!");
            tebakAngka(); 
        } else {
            console.log(`\nBenar! Angkanya adalah ${angkaRahasia}. Kamu butuh ${jumlahPercobaan} percobaan.`);
            rl.close(); 
        }
    });
}

tebakAngka();