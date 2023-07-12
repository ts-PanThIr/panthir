import {defineStore} from 'pinia';
import moment from 'moment';
import {EMessageType, useNotificationStore} from "~/stores/notificationStore";

interface ITitle {
  discount: number;
  extra: number;
  fees: number;
  value: number;
  fine: number;
  quantityInstallments: number;
  entryAt: string;
}

export interface IInstallment {
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
    totalFees (state): number {
      let totalFees = 0;
      if (state.title.fees && state.title.value && state.title.quantityInstallments) {
        const fees = state.title.fees / 100 / 12
        const divisor = Math.pow(1 + fees, state.title.quantityInstallments);
        const installment = (state.title.value * fees * divisor) / (divisor - 1);
        totalFees = ((installment * state.title.quantityInstallments) - state.title.value);
      }
      return totalFees;
    },
    totalValue (state): number {
      const value =
        state.title.value +
        this.totalFees +
        state.title.fine +
        state.title.extra -
        state.title.discount;

      return Number(value.toFixed(3)) || 0;
    },
  },
  actions: {
    async createInstallments(): Promise<void> {
      if (!(
        this.title.value > 0 &&
        this.title.quantityInstallments > 0
      )) {
        useNotificationStore().addMessage({text: 'Check gross or quantity installments values.', type: EMessageType.Danger})
        return
      }
      this.installments = [];

      //get base date based on skipped time
      const baseDate = moment(this.title.entryAt, 'DD/MM/YYYY').add(1, 'month');
      
      // split values
      const quantityInstallments = this.title.quantityInstallments;
      const partialValue = Number((this.totalValue / this.title.quantityInstallments).toFixed(2));
      const partialFine = Number((this.title.fine / quantityInstallments).toFixed(2));
      const partialExtra = Number((this.title.extra / quantityInstallments).toFixed(2));
      const partialDiscount = Number((this.title.discount / quantityInstallments).toFixed(2));
      
      const monthlyFeesRate = Number((this.title.fees / 100 / 12));
      let openDebit = this.title.value;
      
      for (let temp = 0; temp < quantityInstallments -1; temp++) {
        const monthlyFees = (openDebit * monthlyFeesRate);
        openDebit -= ((partialValue) - monthlyFees)
        
        baseDate.add(1, 'months');
        this.installments.push({
          value: (partialValue - monthlyFees - partialExtra),
          fees: monthlyFees,
          fine: partialFine,
          extra: partialExtra,
          discount: partialDiscount,
          date: baseDate.format('DD/MM/YYYY'),
          total: partialValue
        });
      }

      // not beautiful, but better for performance
      const monthlyFees = (openDebit * monthlyFeesRate);
      openDebit -= (partialValue - monthlyFees)
      
      //the fixes for float are calculated at the end, but goes on the start of the array
      const diffValue = this.title.value - (partialValue * quantityInstallments);
      const diffFine = this.title.fine - (partialFine * quantityInstallments);
      const diffExtra = this.title.extra - (partialExtra * quantityInstallments);
      const diffDiscount = this.title.discount - (partialDiscount * quantityInstallments);

      console.log(this.totalValue, openDebit, partialValue)
      
      baseDate.add(1, 'months');
      this.installments.push({
        value: partialValue - monthlyFees + diffValue,
        fees: monthlyFees,
        fine: partialFine + diffFine,
        extra: partialExtra + diffExtra,
        discount: partialDiscount + diffDiscount,
        date: baseDate.format('DD/MM/YYYY'),
        total: partialValue
      });
      
      console.log(openDebit);
    },
  },
});
