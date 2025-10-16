const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
});

let angkaAcak = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

console.log("Tebak angka antara 1 sampai 100!");

function tanya() {
    rl.question("Masukkan tebakanmu: ", (tebakan) => {
        if (isNaN(tebakan)) {
            console.log("Error: Masukkan angka yang valid!");
            return tanya();
        }

        percobaan++;
        tebakan = parseInt(tebakan);

        if (tebakan > angkaAcak) {
            console.log("Terlalu tinggi! Coba lagi.");
            tanya();
        } else if (tebakan < angkaAcak) {
            console.log("Terlalu rendah! Coba lagi.");
            tanya();
        } else {
            console.log(
            `Selamat! Kamu berhasil menebak angka ${angkaAcak} dengan benar.`
            );
            console.log(`Jumlah percobaan: ${percobaan}x`);
            rl.close();
        }
    });
}

tanya();
