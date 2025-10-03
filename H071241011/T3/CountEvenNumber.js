function countEvenNumbers(min, max) {
    let i = 1
    let jumlah = 0
    let evenNumber = []

    while (2*i<=max) {
        if (2*1>=min) {
            evenNumber.push(2*i)
        }
        i++
        jumlah++
    }
    console.log(jumlah, evenNumber)
}

countEvenNumbers(1,10)