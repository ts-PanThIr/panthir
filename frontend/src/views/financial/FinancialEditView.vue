<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Financial title"
      icon="fas fa-money-bill-wave-alt"
      bg-color="bg-secondary"
      text-color="white"
    />
    <v-card-text>
      <v-form ref="titleForm">
        <v-row>
          <v-col cols="8">
            <the-person-autocomplete :rules="[v => !!v || 'Item is required']"/>
          </v-col>
          <v-col cols="4">
            <TheDatepicker
              v-model="title.entryAt"
              hours
              label="Entry Date"
              :rules="[v => !!v || 'Item is required']"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="4">
            <v-text-field
              v-model="title.title"
              v-mask="'SSS-######'"
              label="Title"
              required
            />
          </v-col>
          <v-col cols="4">
            <v-text-field
              v-model="title.account"
              label="Account"
              required
            />
          </v-col>
          <v-col cols="4">
            <v-text-field
              v-model="title.counterpartAccount"
              label="Counterpart account"
              required
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12">
            <v-textarea v-model="title.description" label="Description"/>
          </v-col>
        </v-row>

        <v-card class="my-4" color="surfaceLighten">
          <v-card-title>Values</v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="3">
                <v-text-field
                  v-model="title.quantityInstallments"
                  v-mask="'###'"
                  label="Quantity Installments"
                  :rules="[v => (!!v) || 'Item is required']"
                  @focus="$event.target.select()"
                />
              </v-col>
              <v-col cols="3">
                <the-currency-input
                  v-model.lazy="title.value"
                  label="Gross +"
                  color="success"
                  :rules="[v => !!v || 'Item is required']"
                />
              </v-col>
              <v-col cols="3">
                <the-currency-input
                  v-model.lazy="title.fees"
                  color="success"
                  label="Fees %"
                  :rules="[v => (!!v) || 'Item is required']"
                  :format="{ style: 'percent', minimumFractionDigits: 2, maximumFractionDigits: 2 }"
                />
              </v-col>
              <v-col cols="3">
                <the-currency-input
                  v-model.lazy="title.fine"
                  color="success"
                  label="Fine +"
                />
              </v-col>
              <v-col cols="4">
                <the-currency-input
                  v-model.lazy="title.extra"
                  label="Extra +"
                  color="success"
                  @blur="updateExtra()"
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
                  :rules="[v => !!v || 'Item is required']"
                />
              </v-col>
            </v-row>
            <v-row class="justify-end">
              <v-btn class="mx-3 mb-3" color="secondary" @click="process">
                <i class="fa fa-gear"/>
                Process
              </v-btn>
            </v-row>
          </v-card-text>
        </v-card>

        <financial-installment-table :installments="installments"/>
      </v-form>
      <v-container fluid class="justify-end d-flex">
        <v-btn color="success" @click="send"> Send</v-btn>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import {
  TheDatepicker,
  ThePersonAutocomplete,
  TheCurrencyInput,
  TheCardTitle,
} from '~/components';
import {useFinancialStore} from '~/stores';
import {storeToRefs} from 'pinia';
import {mask} from 'vue-the-mask';
import FinancialInstallmentTable from '~/views/financial/FinancialInstallmentTable.vue';
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'FinancialTitleForm',
  components: {
    TheDatepicker,
    ThePersonAutocomplete,
    TheCurrencyInput,
    FinancialInstallmentTable,
    TheCardTitle,
  },
  directives: { mask },
  async setup() {
    const financialStore = useFinancialStore();
    const {title, totalValue, installments, quantityInstallments} = storeToRefs(financialStore);

    const data = {
      titleForm: ref(null) as unknown as HTMLFormElement,
    };
    
    return {
      installments,
      title,
      totalValue,
      quantityInstallments,
      updateExtra: financialStore.updateExtra,
      ...data
    };
  },
  methods: {
    async process(): Promise<void> {
      if(await this.validate()) {
        const store = useFinancialStore();
        await store.createInstallments();
      }
    },
    async send(): Promise<void> {
      if(await this.validate()) {
        const financialStore = useFinancialStore();
        return financialStore.send();
      }
    },
    
    async validate(): Promise<boolean> {
      return (await this.titleForm.validate()).valid;
    },
  },
});
</script>
