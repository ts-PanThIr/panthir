import { defineStore } from "pinia";

export const useFinancialStore = defineStore({
  id: "financial",
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
    totalValue: (state) => {
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
      if (!(this.title.value > 0 && this.title.quantityInstallments > 0)) {
        console.log("burrice");
        return;
      }
      let partialValue = Number(
        (this.title.value / this.title.quantityInstallments).toFixed(2)
      );
      let partialFees =
        Number(
          (this.title.fees / this.title.quantityInstallments).toFixed(2)
        ) || null;
      let partialFine =
        Number(
          (this.title.fine / this.title.quantityInstallments).toFixed(2)
        ) || null;
      let partialExtra =
        Number(
          (this.title.extra / this.title.quantityInstallments).toFixed(2)
        ) || null;
      let partialDiscount =
        Number(
          (this.title.discount / this.title.quantityInstallments).toFixed(2)
        ) || null;

      //check for differences
      for (let temp = this.title.quantityInstallments; temp > 0; temp--) {
        if (temp === 1) {
          const diffValue =
            this.title.value - partialValue * this.title.quantityInstallments;
          const diffFees =
            this.title.fees - partialFees * this.title.quantityInstallments;
          const diffFine =
            this.title.fine - partialFine * this.title.quantityInstallments;
          const diffExtra =
            this.title.extra - partialExtra * this.title.quantityInstallments;
          const diffDiscount =
            this.title.discount -
            partialDiscount * this.title.quantityInstallments;

          this.installmentAdd({
            value: Number((partialValue + diffValue).toFixed(2)) || null,
            fees: Number((partialFees + diffFees).toFixed(2)) || null,
            fine: Number((partialFine + diffFine).toFixed(2)) || null,
            extra: Number((partialExtra + diffExtra).toFixed(2)) || null,
            discount:
              Number((partialDiscount + diffDiscount).toFixed(2)) || null,
          });
          continue;
        }
        this.installmentAdd({
          value: partialValue,
          fees: partialFees,
          fine: partialFine,
          extra: partialExtra,
          discount: partialDiscount,
        });
      }
    },
    async installmentAdd({ value, fees, fine, extra, discount }) {
      this.installments.push({ value, fees, fine, extra, discount });
    },
    async getPaymentCondition() {
      try {
        const path = `${this.$apiUrl}/api/financial/payment-condition/`;

        this.list = await this.$http.get(path).then((d) => {
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
