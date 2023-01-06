<template>
  <v-form ref="titleForm">
    <v-row>
      <v-col cols="8">
        <the-person-autocomplete :rules="[(v) => !!v || 'Item is required']" />
      </v-col>
      <v-col cols="4">
        <TheDatepicker
          v-model="title.entryAt"
          hours
          label="Entry Date"
          :rules="[(v) => !!v || 'Item is required']"
        />
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="4">
        <v-text-field
          v-model="title.title"
          v-mask="'SSS-######'"
          :rules="[(v) => !!v || 'Item is required']"
          label="Title"
          required
        />
      </v-col>
      <v-col cols="4">
        <v-text-field
          v-model="title.account"
          :rules="[(v) => !!v || 'Item is required']"
          label="Account"
          required
        />
      </v-col>
      <v-col cols="4">
        <v-text-field
          v-model="title.counterpartAccount"
          :rules="[(v) => !!v || 'Item is required']"
          label="Counterpart account"
          required
        />
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12">
        <v-textarea
          v-model="title.description"
          label="Description"
        />
      </v-col>
    </v-row>

    <v-card
      class="my-4"
      color="surfaceLighten"
    >
      <v-card-title>Values</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="3">
            <v-select
              v-model="title.quantityInstallments"
              :items="paymentConditions"
              item-title="name"
              return-object
              label="Quantity Installments"
              :rules="[(v) => (!!v && !!v.id) || 'Item is required']"
            />
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.value"
              label="Gross +"
              color="success"
              :rules="grossRule"
            />
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.fees"
              label="Fees +"
              color="success"
            />
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.fine"
              label="Fine +"
              color="success"
            />
          </v-col>
          <v-col cols="4">
            <the-currency-input
              v-model.lazy="title.extra"
              label="Extra +"
              color="success"
            />
          </v-col>
          <v-col cols="4">
            <the-currency-input
              v-model.lazy="title.discount"
              label="Discount -"
              color="warning"
            />
          </v-col>
          <v-col cols="4">
            <the-currency-input
              v-model="totalValue"
              label="Total ="
              color="secondary"
              readonly
              :rules="[(v) => !!v || 'Item is required']"
            />
          </v-col>
        </v-row>
        <v-row class="justify-end">
          <v-btn
            class="mx-3 mb-3"
            color="secondary"
            @click="validate"
          >
            <i class="fa fa-gear" />
            Process
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>

    <financial-installment-table :installments="installments" />
  </v-form>
</template>

<script>
import FinancialInstallmentTable from '~/views/financial/FinancialInstallmentTable.vue';
import {
  TheDatepicker,
  ThePersonAutocomplete,
  TheCurrencyInput
} from '~/components';
import {useFinancialStore} from '~/stores';
import {storeToRefs} from 'pinia';
import {mask} from 'vue-the-mask';

export default {
  name: 'FinancialTitleForm',
  components: { TheDatepicker, ThePersonAutocomplete, TheCurrencyInput, FinancialInstallmentTable },
  directives: { mask },
  async setup() {
    const paymentConditions = await useFinancialStore().getPaymentCondition();
    const {title, totalValue, installments} = storeToRefs(
      useFinancialStore()
    );
    const createInstallments = useFinancialStore().createInstallments;
    return {
      installments,
      title,
      totalValue,
      createInstallments,
      paymentConditions,
    };
  },
  data: () => ({
    tab: "1",
    grossRule: [
      (v) => !!v || 'Item is required',
    ],
  }),
  methods: {
    validate: async function () {
      if (!(await this.$refs.titleForm.validate()).valid) {
        return;
      }
      this.createInstallments();
    },
  },
};
</script>
