const readline = require("readline");
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

function tanya() {
    rl.question("Masukkan salah satu angka dari 1 sampai 100: ", (input) => {
        let tebakan = parseInt(input);
        if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
            console.log("error, masukkan angka antara 1 sampai 100");
            return tanya();
        }

        attempts++;

        if (tebakan === target) {
            console.log(`Selamat! Anda menebak benar, angkanya adalah ${target}.`);
            console.log(`Jumlah percobaan: ${attempts}`);
            rl.close();
        } else if (tebakan > target) {
            console.log("Terlalu tinggi! coba lagi");
            tanya();
        } else {
            console.log("Terlalu rendah! coba lagi");
            tanya();
        }
    });
}
