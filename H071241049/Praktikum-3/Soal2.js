const readline = require("readline");
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan harga barang: ", (hargaInput) => {
    let harga = parseFloat(hargaInput);

    if (isNaN(harga) || harga <= 0) {
        console.log("error: harga harus angka positif");
        rl.close();
        return;
    }

    rl.question("Masukkan jenis barang (elektronik, pakaian, makanan, lainnya): ", (jenis) => {
        let diskon = 0;

        switch (jenis.toLowerCase()) {
            case "elektronik": diskon = 10; break;
            case "pakaian": diskon = 20; break;
            case "makanan": diskon = 5; break;
            case "lainnya": diskon = 0; break;
            default:
                console.log("error, jenis barang tidak valid");
                rl.close();
                return;
        }

        let potongan = harga * (diskon / 100);
        let hargaAkhir = harga - potongan;

        console.log(`\nHarga awal: Rp ${harga}`);
        console.log(`Diskon: ${diskon}%`);
        console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);
        rl.close();
    });
});
