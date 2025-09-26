/*
Buatlah sebuah fungsi `countEvenNumbers` yang menerima parameter dua angka yakni, `start` dan `end`. 
Dari fungsi tersebut hitunglah berapa banyak bilangan genap yang ada dalam interval tersebut, termasuk 
`start` dan `end` jika mereka genap. 
*/

function countEvenNumbers(start, end) {
  let result = [];
  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      result.push(i);
    }
  }
  console.log(`${result.length} [${result.join(", ")}]`);
  return result.length;
}

countEvenNumbers(1, 100); 
