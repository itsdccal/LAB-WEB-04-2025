const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
});

const days = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl.question("Masukkan hari: ", (hari) => {
    let hariLower = hari.toLowerCase();
    let indexHari = days.indexOf(hariLower);

    if (indexHari === -1) {
        console.log("Error: Hari tidak valid!");
        rl.close();
        return;
    }

    rl.question("Masukkan jumlah hari yang akan datang: ", (jumlah) => {
        if (isNaN(jumlah)) {
            console.log("Error: Jumlah hari harus berupa angka!");
            rl.close();
            return;
        }

        jumlah = parseInt(jumlah);
        let hasilIndex = (indexHari + jumlah) % 7;
        let hasilHari = days[hasilIndex];

        console.log(`${jumlah} hari setelah ${hari} adalah ${hasilHari}`);
        rl.close();
    });
});
