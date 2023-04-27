<template>
  <v-row v-if="installments.length">
    <v-col cols="12">
      <v-table>
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
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
            <td>{{ index + 1 }}</td>
            <td>{{ item.date }}</td>
            <td>{{ formatValue(item.value) }}</td>
            <td>{{ formatValue(item.fees) }}</td>
            <td>{{ formatValue(item.fine) }}</td>
            <td>{{ formatValue(item.extra) }}</td>
            <td>{{ formatValue(item.discount) }}</td>
            <td>{{ formatValue(item.total) }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'FinancialInstallmentTable',
  props: {
    installments: { type: Array, default: null },
  },
  async setup() {},
  methods: {
    formatValue(e) {
      return Intl.NumberFormat(this.locale, {
        style: 'currency',
        currency: this.currency,
      }).format(e);
    },
  },
};
</script>
