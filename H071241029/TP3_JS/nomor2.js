const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
});

rl.question("Masukkan harga barang: ", (harga) => {
    if (isNaN(harga)) {
        console.log("Error: Harga harus berupa angka!");
        rl.close();
        return;
    }
    rl.question(
        "Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ",
        (jenis) => {
            harga = parseFloat(harga);
            let diskon = 0;

        switch (jenis.toLowerCase()) {
            case "elektronik":
                diskon = 0.1;
                break;
            case "pakaian":
                diskon = 0.2;
                break;
            case "makanan":
                diskon = 0.05;
                break;
            case "lainnya":
                diskon = 0;
                break;
                default:
                    console.log("Jenis barang tidak dikenal, tanpa diskon.");
        }

        let potongan = harga * diskon;
        let hargaAkhir = harga - potongan;

        console.log(`\nHarga awal: Rp ${harga}`);
        console.log(`Diskon: ${diskon * 100}%`);
        console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

        rl.close();
        }
    );
});
