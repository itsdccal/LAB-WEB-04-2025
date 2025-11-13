function countEvenNumbers(start, end) {
  if (isNaN(start) || isNaN(end)) {
    throw new Error("Parameter harus berupa angka!");
  }

  let evens = [];
  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      evens.push(i);
    }
  }
  return `${evens.length} [${evens.join(", ")}]`;
}

console.log(countEvenNumbers(3, 13));
