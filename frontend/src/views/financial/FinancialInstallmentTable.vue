<template>
  <v-row v-if="installments.length">
    <v-col cols="12">
      <v-table>
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Debt paid</th>
            <th>Remaining debt</th>
            <th>Fees</th>
            <th>Fine</th>
            <th>Extra</th>
            <th>Discount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        <template v-for="(item, index) in installments" :key="index" >
          <tr>
            <td>{{ index + 1 }}</td>
            <td>{{ item.date }}</td>
            <td>{{ formatValue(item.value) }}</td>
            <td>{{ formatValue(item.remainingDebt) }}</td>
            <td>{{ formatValue(item.fees) }}</td>
            <td>{{ formatValue(item.fine) }}</td>
            <td>{{ formatValue(item.extra) }}</td>
            <td>{{ formatValue(item.discount) }}</td>
            <td>{{ formatValue(item.total) }}</td>
          </tr>
          <tr v-if="(index + 1) % 12 === 0">
            <td class="font-weight-bold">{{ (index + 1) / 12 }}</td>
            <td class="font-weight-bold"></td>
            <td class="font-weight-bold">{{ sumColumn(index, 'value') }}</td>
            <td class="font-weight-bold">--</td>
            <td class="font-weight-bold">{{ sumColumn(index, 'fees') }}</td>
            <td class="font-weight-bold">{{ sumColumn(index, 'fine') }}</td>
            <td class="font-weight-bold">{{ sumColumn(index, 'extra') }}</td>
            <td class="font-weight-bold">{{ sumColumn(index, 'discount') }}</td>
            <td class="font-weight-bold">{{ sumColumn(index, 'total') }}</td>
          </tr>
        </template>
        <tr>
          <td class="font-weight-bold">Total</td>
          <td class="font-weight-bold"></td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'value', installments.length) }}</td>
          <td class="font-weight-bold">--</td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'fees', installments.length) }}</td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'fine', installments.length) }}</td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'extra', installments.length) }}</td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'discount', installments.length) }}</td>
          <td class="font-weight-bold">{{ sumColumn(installments.length -1, 'total', installments.length) }}</td>
        </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import type {IInstallment} from "~/stores";

export default defineComponent({
  name: 'FinancialInstallmentTable',
  props: {
    installments: { 
      type: Array as () => IInstallment[], 
      default: null 
    },
  },
  methods: {
    formatValue(e): string {
      return Intl.NumberFormat(this.configVars.$locale, {
        style: 'currency',
        currency: this.configVars.$currency,
      }).format(e);
    },
    sumColumn(index, name, limit = 12): string {
      let temp = 0;
      for (let i = index; i > index - limit ;i--){
        temp += this.installments[i][name];
      }
      
      return this.formatValue(temp.toFixed(2));
    }
  },
});
</script>
