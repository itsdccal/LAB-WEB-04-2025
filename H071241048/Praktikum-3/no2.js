// no 2

function hitungDiskonSwitch(harga, jenis) {
        let diskon
        switch (jenis.toLowerCase()) {
            case 'elektronik':
                diskon = 0.1
                break;
            case 'pakaian':
                diskon = 0.2
                break;
            case 'makanan':
                diskon = 0.05
                break;
        default:
            diskon = 0
    }
    console.log(`Harga awal: ${harga}`)
    let hargaAkhir = harga - (harga * diskon)
    console.log(`Diskon: ${diskon * 100}%`);
    return `Total yang harus dibayar: ${hargaAkhir}`
}

let hargaInput = parseInt(prompt("Masukkan harga barang: "))
let jenisInput = prompt("Masukkan jenis barang (elektronik/pakaian/makanan/lainnya): ")

console.log(hitungDiskonSwitch(hargaInput, jenisInput));
