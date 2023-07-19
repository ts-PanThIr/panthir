import {defineStore} from 'pinia';
import moment from 'moment';
import {EMessageType, useNotificationStore} from "~/stores/notificationStore";
import {FormHelper} from "~/helpers";

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
  remainingDebt: number;
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
      fees: 6.65,
      value: 20000,
      fine: 7.46,
      quantityInstallments: 60,
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
        const fees = Number((state.title.fees / 100 / 12));        
        const installment = state.title.value * fees * 
          (Math.pow((1 + fees), state.title.quantityInstallments)) /
          ((Math.pow((1 + fees), state.title.quantityInstallments)) - 1);
        
        totalFees = Number(((installment * state.title.quantityInstallments) - ( state.title.value )).toFixed(2));
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
      
      if(this.title.extra === 0) {
        this.updateExtra()
      }

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
        const monthlyFees = Number((openDebit * monthlyFeesRate).toFixed(2));
        const monthlyExtra = monthlyFees * import.meta.env.VITE_APP_TAX_SELO
        openDebit -= (partialValue - monthlyFees - monthlyExtra)
        
        baseDate.add(1, 'months');
        this.installments.push({
          value: (partialValue - monthlyFees - monthlyExtra),
          fees: monthlyFees,
          fine: partialFine,
          extra: monthlyExtra,
          discount: partialDiscount,
          date: baseDate.format('DD/MM/YYYY'),
          total: partialValue,
          remainingDebt: openDebit
        });
      }

      // not beautiful, but better for performance
      const monthlyFees = (openDebit * monthlyFeesRate);
      const diffValue = this.totalValue - (partialValue * quantityInstallments);
      const diffFine = this.title.fine - (partialFine * quantityInstallments);
      const diffExtra = this.title.extra - (partialExtra * quantityInstallments);
      const diffDiscount = this.title.discount - (partialDiscount * quantityInstallments);
      openDebit -= (partialValue - monthlyFees + diffValue - partialExtra + diffExtra)
      
      baseDate.add(1, 'months');
      this.installments.push({
        value: partialValue - monthlyFees + diffValue,
        fees: monthlyFees,
        fine: partialFine + diffFine,
        extra: partialExtra + diffExtra,
        discount: partialDiscount + diffDiscount,
        date: baseDate.format('DD/MM/YYYY'),
        total: partialValue,
        remainingDebt: openDebit
      });
    },
    updateExtra(): void
    {
      const selo_tax = Number((this.totalFees * import.meta.env.VITE_APP_TAX_SELO).toFixed(2));
      if(selo_tax != this.title.extra) {
        this.title.extra += selo_tax
      }
    },

    async send(): Promise<void> {
      const form = {
        title: this.title,
        installments: this.installments
      }
      
      const formData = FormHelper.jsonToFormData(form);
      return await this.$http
        .post(`${this.$apiUrl}/api/financial/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  },
});
