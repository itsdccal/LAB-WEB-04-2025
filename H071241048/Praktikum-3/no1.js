// no 1
function countEvenNunmbers(start, end) {
    let count = 0
    let arr = []
    for (let i = start; i <= end; i++) {
            if (i % 2 === 0) {
                    count++
                    arr.push(i)
                }
            }
            return `Total bil genap: ${count}, isinya nih: [${arr}]`
        
        }

console.log(countEvenNunmbers(1, 10)); 
