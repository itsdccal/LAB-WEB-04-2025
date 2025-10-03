const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

rl.question('Masukkan hari: ', (hariAwal) => {
    rl.question('Masukkan jumlah hari yang akan datang: ', (jumlahHariDatang) => {
        const hariIndexAwal=hari.indexOf(hariAwal);
        const targetJumlahHari=parseInt(jumlahHariDatang);
        const hariFinalIndex=(hariIndexAwal+targetJumlahHari)%7;

        console.log(jumlahHariDatang+' hari setelah '+hariAwal+' adalah '+hari[hariFinalIndex]);
        rl.close();
    });
});