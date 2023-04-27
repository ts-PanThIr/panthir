import { defineStore } from 'pinia';
import moment from 'moment';

export const useFinancialStore = defineStore({
  id: 'financial',
  state: () => ({
    title: {
      discount: null,
      extra: null,
      fees: null,
      value: null,
      fine: null,
      quantityInstallments: null,
    },
    list: [],
    installments: [],
    paymentCondition: [],
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
    async createInstallments() {
      if (
        !(
          this.title.value > 0 &&
          this.title.quantityInstallments?.maximumInstallmentQuantity > 0
        )
      ) {
        console.log('error burr');
        return;
      }
      this.installments = [];

      // split values
      const quantityInstallments =
        this.title.quantityInstallments.maximumInstallmentQuantity;
      const partialValue = Number(
        (this.title.value / quantityInstallments).toFixed(2),
      );
      const partialFees =
        Number((this.title.fees / quantityInstallments).toFixed(2)) || null;
      const partialFine =
        Number((this.title.fine / quantityInstallments).toFixed(2)) || null;
      const partialExtra =
        Number((this.title.extra / quantityInstallments).toFixed(2)) || null;
      const partialDiscount =
        Number((this.title.discount / quantityInstallments).toFixed(2)) || null;

      //get base date based on skipped time
      const baseDate = moment(this.title.entryAt, 'DD/MM/YYYY').add(
        this.title.quantityInstallments.firstInterval,
        'days',
      );

      for (let temp = 0; temp < quantityInstallments; temp++) {
        //get date
        if (temp === 0) {
          const diffValue =
            this.title.value - partialValue * quantityInstallments;
          const diffFees = this.title.fees - partialFees * quantityInstallments;
          const diffFine = this.title.fine - partialFine * quantityInstallments;
          const diffExtra =
            this.title.extra - partialExtra * quantityInstallments;
          const diffDiscount =
            this.title.discount - partialDiscount * quantityInstallments;

          this.installmentAdd({
            value: Number((partialValue + diffValue).toFixed(2)) || null,
            fees: Number((partialFees + diffFees).toFixed(2)) || null,
            fine: Number((partialFine + diffFine).toFixed(2)) || null,
            extra: Number((partialExtra + diffExtra).toFixed(2)) || null,
            discount:
              Number((partialDiscount + diffDiscount).toFixed(2)) || null,
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
    async installmentAdd({ value, fees, fine, extra, discount, date }) {
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
    async getPaymentCondition() {
      try {
        const path = `${this.$apiUrl}/api/financial/payment-condition/`;

        this.list = await this.$http.get(path).then(d => {
          this.paymentCondition = d.data.data;
          return d.data.data;
        });
        return this.list;
      } catch (error) {
        console.log(error);
      }
    },
  },
});
