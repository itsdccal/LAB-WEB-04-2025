/**
 * @param {number} start
 * @param {number} end
 * @returns {number[]}
 */
function countEvenNumbers(start, end) {
  const evenNumbers = [];

  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      evenNumbers.push(i);
    }
  }

  return evenNumbers;
}

const result = countEvenNumbers(1, 10);

console.log(`${result.length} [${result.join(', ')}]`);