import {defineStore} from 'pinia';
import moment from 'moment';
import {EMessageType, useNotificationStore} from "~/stores/notificationStore";
import {FormHelper} from "~/helpers";
import {computed, inject, ref} from "vue";
import type {Ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

interface IPerson {
  name: string;
  id: string;
}

interface ITitle {
  discount: number;
  extra: number;
  fees: number;
  value: number;
  fine: number;
  quantityInstallments: number;
  entryAt: string;
  title: string;
  account: string;
  counterpartAccount: string;
  description: string;
  person: IPerson;
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
  list: Ref<ITitle[]>;
  title: Ref<ITitle>;
  installments: Ref<IInstallment[]>;
  quantityInstallments: Ref<number[]>;
}

export const useFinancialStore = defineStore('financial', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    title: ref({
      discount: 0,
      extra: ref(0),
      fees: 6.65,
      value: 20000,
      fine: 7.46,
      quantityInstallments: 60,
      entryAt: moment(new Date()).format("DD/MM/YYYY")
    }) as Ref<ITitle>,
    list: ref([]) as Ref<ITitle[]>,
    installments: ref([]) as Ref<IInstallment[]>,
    quantityInstallments: ref([...Array(60).keys()]) as Ref<number[]>,
  }

  const GETTERS = {
    totalFees: computed(() => {
      let totalFees = 0;
      if (STATE.title.value.fees && STATE.title.value.value && STATE.title.value.quantityInstallments) {
        const fees = Number((STATE.title.value.fees / 100 / 12));
        const installment = STATE.title.value.value * fees *
          (Math.pow((1 + fees), STATE.title.value.quantityInstallments)) /
          ((Math.pow((1 + fees), STATE.title.value.quantityInstallments)) - 1);

        totalFees = Number(((installment * STATE.title.value.quantityInstallments) - (STATE.title.value.value)).toFixed(2));
      }
      return totalFees;
    }),
    totalValue: computed(() => {
      const value =
        STATE.title.value.value +
        GETTERS.totalFees.value +
        STATE.title.value.fine +
        STATE.title.value.extra -
        STATE.title.value.discount;

      return Number(value.toFixed(3)) || 0;
    })
  }

  const ACTIONS = {
    createInstallments: async function (): Promise<void> {
      debugger
      if (!(STATE.title.value.value > 0 && STATE.title.value.quantityInstallments > 0)) {
        useNotificationStore().addMessage({
          text: 'Check gross or quantity installments values.',
          type: EMessageType.Danger
        })
        return
      }
      STATE.installments.value = [];

      if (STATE.title.value.extra === 0) {
        this.updateExtra()
      }

      //get base date based on skipped time
      const baseDate = moment(STATE.title.value.entryAt, 'DD/MM/YYYY').add(1, 'month');

      // split values
      const quantityInstallments = STATE.title.value.quantityInstallments;
      const partialValue = Number((GETTERS.totalValue.value / STATE.title.value.quantityInstallments).toFixed(2));
      const partialFine = Number((STATE.title.value.fine / quantityInstallments).toFixed(2));
      const partialExtra = Number((STATE.title.value.extra / quantityInstallments).toFixed(2));
      const partialDiscount = Number((STATE.title.value.discount / quantityInstallments).toFixed(2));

      const monthlyFeesRate = Number((STATE.title.value.fees / 100 / 12));
      let openDebit = STATE.title.value.value;

      for (let temp = 0; temp < quantityInstallments - 1; temp++) {
        const monthlyFees = Number((openDebit * monthlyFeesRate).toFixed(2));
        const monthlyExtra = monthlyFees * import.meta.env.VITE_APP_TAX_SELO
        openDebit -= (partialValue - monthlyFees - monthlyExtra)

        baseDate.add(1, 'months');
        STATE.installments.value.push({
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
      const diffValue = GETTERS.totalValue.value - (partialValue * quantityInstallments);
      const diffFine = STATE.title.value.fine - (partialFine * quantityInstallments);
      const diffExtra = STATE.title.value.extra - (partialExtra * quantityInstallments);
      const diffDiscount = STATE.title.value.discount - (partialDiscount * quantityInstallments);
      openDebit -= (partialValue - monthlyFees + diffValue - partialExtra + diffExtra)

      baseDate.add(1, 'months');
      STATE.installments.value.push({
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
    updateExtra: function (): void {
      const selo_tax = Number((GETTERS.totalFees.value * import.meta.env.VITE_APP_TAX_SELO).toFixed(2));
      if (selo_tax != STATE.title.value.extra) {
        STATE.title.value.extra += selo_tax
      }
    },
    send: async function (): Promise<void> {
      const form = {
        title: STATE.title.value,
        installments: STATE.installments
      }

      const formData = FormHelper.jsonToFormData(form);
      return await configVars.$http.post(`${configVars.$apiUrl}/api/financial/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  }

  return {...STATE, ...GETTERS, ...ACTIONS}
})
