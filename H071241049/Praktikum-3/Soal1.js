function countEvenNumbers(start, end) {
    let evens = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            evens.push(i);
        }
    } return { count: evens.length, numbers: evens };
} 
    console.log(countEvenNumbers(1, 10));