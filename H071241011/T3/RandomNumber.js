const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const randomNumber = Math.floor(Math.random()*100) +1;
let percobaan = 0;

function tebakAngka() {
    rl.question('Masukkan salah satu angka 1 sampai 100: ', (inputAngka) => {
        const guess = parseInt(inputAngka);

        percobaan++;

        if (guess > randomNumber) {
            console.log('Terlalu tinggi! Coba lagi.');
            tebakAngka();
        } else if (guess < randomNumber) {
            console.log('Terlalu rendah! Coba lagi.');
            tebakAngka();
        } else {
            console.log('Selamat! kamu berhasil menebak angka '+randomNumber+'dengan benar.');
            console.log('Sebanyak '+percobaan+'x percobaan');
            rl.close();
        }
    });
}

tebakAngka();