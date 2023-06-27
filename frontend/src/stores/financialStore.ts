import {defineStore} from 'pinia';
import moment from 'moment';

interface ITitle {
  discount: number;
  extra: number;
  fees: number;
  value: number;
  fine: number;
  quantityInstallments: number;
  entryAt: string;
}

interface IInstallment {
  value: number;
  fees: number;
  fine: number;
  extra: number;
  discount: number;
  date: string;
  total: number;
}

interface IState {
  list: ITitle[];
  title: ITitle;
  installments: IInstallment[]; // must be the index~
  quantityInstallments: number[];
}

export const useFinancialStore = defineStore({
  id: 'financial',
  state: (): IState => ({
    title: {
      discount: 0,
      extra: 0,
      fees: 0,
      value: 0,
      fine: 0,
      quantityInstallments: 0,
      entryAt: moment(new Date()).format("DD/MM/YYYY")
    },
    list: [],
    installments: [],
    quantityInstallments: [...Array(60).keys()],
  }),
  getters: {
    totalValue: state => {
      const value =
        state.title.value +
        state.title.fees +
        state.title.fine +
        state.title.extra -
        state.title.discount;

      return Number(value.toFixed(3)) || null;
    },
  },
  actions: {
    async createInstallments(): Promise<void> {
      if (!(
        this.title.value > 0 &&
        this.title.quantityInstallments > 0
      )) {
        console.log('error burr');
        return;
      }
      this.installments = [];

      // split values
      const quantityInstallments =
        this.title.quantityInstallments;
      const partialValue = Number((this.title.value / quantityInstallments).toFixed(2));
      const partialFees = Number((this.title.fees / quantityInstallments).toFixed(2)) || 0;
      const partialFine = Number((this.title.fine / quantityInstallments).toFixed(2)) || 0;
      const partialExtra = Number((this.title.extra / quantityInstallments).toFixed(2)) || 0;
      const partialDiscount = Number((this.title.discount / quantityInstallments).toFixed(2)) || 0;

      //get base date based on skipped time
      const baseDate = moment(this.title.entryAt, 'DD/MM/YYYY').add(
        30,
        'days',
      );

      for (let temp = 0; temp < quantityInstallments; temp++) {
        //get date
        if (temp === 0) {
          const diffValue =
            this.title.value - partialValue * quantityInstallments;
          const diffFees = this.title.fees - partialFees * quantityInstallments;
          const diffFine = this.title.fine - partialFine * quantityInstallments;
          const diffExtra = this.title.extra - partialExtra * quantityInstallments;
          const diffDiscount = this.title.discount - partialDiscount * quantityInstallments;

          this.installmentAdd({
            value: Number((partialValue + diffValue).toFixed(2)) || 0,
            fees: Number((partialFees + diffFees).toFixed(2)) || 0,
            fine: Number((partialFine + diffFine).toFixed(2)) || 0,
            extra: Number((partialExtra + diffExtra).toFixed(2)) || 0,
            discount: Number((partialDiscount + diffDiscount).toFixed(2)) || 0,
            date: baseDate.format('DD/MM/YYYY'),
          });
          continue;
        }

        baseDate.add(1, 'months');
        this.installmentAdd({
          value: partialValue,
          fees: partialFees,
          fine: partialFine,
          extra: partialExtra,
          discount: partialDiscount,
          date: baseDate.format('DD/MM/YYYY'),
        });
      }
    },
    async installmentAdd({value, fees, fine, extra, discount, date}) {
      const total = Number((value + fees + fine + extra - discount).toFixed(2));
      this.installments.push({
        value,
        fees,
        fine,
        extra,
        discount,
        date,
        total,
      });
    },
  },
});
