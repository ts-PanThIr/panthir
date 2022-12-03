<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="9">
        <the-person-autocomplete></the-person-autocomplete>
      </v-col>
      <v-col cols="3">
        <TheDatepicker
          v-model="title.entryAt"
          hours
          label="Entry Date"
        ></TheDatepicker>
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
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-text-field
          v-model="title.account"
          :rules="[(v) => !!v || 'Item is required']"
          label="Account"
          required
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-text-field
          v-model="title.counterpartAccount"
          :rules="[(v) => !!v || 'Item is required']"
          label="Counterpart account"
          required
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12">
        <v-textarea
          v-model="title.description"
          label="Description"
        ></v-textarea>
      </v-col>
    </v-row>

    <v-card color="surfaceLighten">
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
            >
            </v-select>
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.value"
              label="Gross +"
              color="success"
            ></the-currency-input>
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.fees"
              label="Fees +"
              color="success"
            ></the-currency-input>
          </v-col>
          <v-col cols="3">
            <the-currency-input
              v-model.lazy="title.fine"
              label="Fine +"
              color="success"
            ></the-currency-input>
          </v-col>
          <v-col cols="4">
            <the-currency-input
              v-model.lazy="title.extra"
              label="Extra +"
              color="success"
            ></the-currency-input>
          </v-col>
          <v-col cols="4">
            <the-currency-input
              v-model.lazy="title.discount"
              label="Discount -"
              color="warning"
            ></the-currency-input>
          </v-col>
          <v-col cols="4">
            {{ totalValue }}
            <the-currency-input
              v-model.lazy="totalValue"
              label="Total ="
              color="secondary"
              readonly
            ></the-currency-input>
          </v-col>
        </v-row>
        <v-row class="justify-end">
          <v-btn
            class="mx-3 mb-3"
            color="secondary"
            @click="createInstallments"
          >
            <i class="fa fa-gear"></i>
            Process
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>

    <v-row v-if="installments.length">
      <v-col cols="12">
        <table>
          <thead>
            <tr>
              <th>Gross</th>
              <th>Fees</th>
              <th>Fine</th>
              <th>Extra</th>
              <th>Discount</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in installments" :key="index">
              <td>{{ item.value }}</td>
              <td>{{ item.fees }}</td>
              <td>{{ item.fine }}</td>
              <td>{{ item.extra }}</td>
              <td>{{ item.discount }}</td>
            </tr>
          </tbody>
        </table>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import { mask } from "vue-the-mask";
import {
  TheDatepicker,
  ThePersonAutocomplete,
  TheCurrencyInput,
} from "~/components";
import { useFinancialStore } from "~/stores";
import { storeToRefs } from "pinia";

export default {
  name: "FinancialTitleForm",
  directives: { mask },
  components: { TheDatepicker, ThePersonAutocomplete, TheCurrencyInput },
  async setup() {
    const paymentConditions = await useFinancialStore().getPaymentCondition();
    const { title, totalValue, installments } = storeToRefs(
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
};
</script>
