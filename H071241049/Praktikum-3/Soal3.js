const readline = require("readline");
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const hariMinggu = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];

rl.question("Masukkan hari: ", (hariInput) => {
    let hari = hariInput.toLowerCase();
    if (!hariMinggu.includes(hari)) {
        console.log("error, nama hari tidak valid");
        rl.close();
        return;
    }

    rl.question("Masukkan jumlah hari yang akan datang: ", (jumlahInput) => {
        let jumlah = parseInt(jumlahInput);
        if (isNaN(jumlah) || jumlah < 0) {
            console.log("error, jumlah hari harus angka positif");
            rl.close();
            return;
        }

        let indexHari = hariMinggu.indexOf(hari);
        let hasilIndex = (indexHari + (jumlah % 7)) % 7;
        console.log(`${jumlah} hari setelah ${hari} adalah ${hariMinggu[hasilIndex]}`);
        rl.close();
    });
});
