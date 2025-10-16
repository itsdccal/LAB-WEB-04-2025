const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('Masukkan Harga Barang: ', (hargaBarang) => {
    rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan,Lainnya): ', (namaBarang) => {
        let harga=parseInt(hargaBarang)
        let diskon=0

        if (namaBarang==='elektronik') {
            diskon=0.1
        } else if (namaBarang==='pakaian') {
            diskon=0.2
        } else if (namaBarang==='makanan') {
            diskon=0.95
        } else if (namaBarang==='lainnya') {
            diskon=0
        }
        hargaSetelahDiskon=hargaBarang*diskon

        console.log('Harga awal: '+harga)
        console.log('Diskon: '+(100-diskon*100)+' %')
        console.log('Harga setelah diskon: '+hargaSetelahDiskon)

        rl.close();
    });
});