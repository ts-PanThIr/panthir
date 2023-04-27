interface DateConstructor {
  addDays(days: number): Date;
  formatDate(date: string): string;
  formatDatefromObject(date: Date): string;
}

Date.prototype.addDays = function (days: number) {
  const date = new Date(this.valueOf());
  date.setDate(date.getDate() + days);
  return date;
};

Date.prototype.formatDate = function (date: string): string {
  const timestamp = Date.parse(date);
  const temp = new Date(timestamp);
  return Date.formatDatefromObject(temp);
};

Date.prototype.formatDatefromObject = function (date: Date): string {
  const day = Number.addLeadingZeros(date.getDate());
  const month = Number.addLeadingZeros(date.getMonth() + 1);
  const year = date.getFullYear();
  const hour = Number.addLeadingZeros(date.getHours());
  const minute = Number.addLeadingZeros(date.getMinutes());

  return `${day}/${month}/${year} ${hour}:${minute}`;
};
