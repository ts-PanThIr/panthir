interface Number {
  adicionarZeroEsquerda(days: number): string;
}

Number.prototype.addLeadingZeros = function (number: number): string {
  return number < 10 ? `0${number}` : `${number}`;
};
