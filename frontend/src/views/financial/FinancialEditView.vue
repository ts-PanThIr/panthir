<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Financial title"
      icon="fas fa-money-bill-wave-alt"
      bg-color="bg-secondary"
      text-color="white"
    />
    <v-card-text>
      <financial-title-form />
      <v-container fluid class="justify-end d-flex">
        <v-btn color="success" @click="validate"> Send </v-btn>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import { usePersonStore } from '~/stores';
import { useRoute } from 'vue-router';
import FinancialTitleForm from './FinancialTitleForm.vue';
import { TheCardTitle } from '~/components';

export default {
  name: 'FinancialEditView',
  components: { FinancialTitleForm, TheCardTitle },
  async setup() {
    const route = useRoute();
    const personStore = usePersonStore();
    if (route.name !== 'PersonNew') {
      // await personStore.getOne(route.params.id);
    }
    const person = personStore.person;
    const personSend = personStore.send;
    return { person, personStore, personSend };
  },
  data: () => ({
    tab: '1',
  }),

  methods: {
    validate: async function () {
      return false;

      if (!(await this.$refs.personIndividual.$refs.form.validate()).valid) {
        this.tab = '1';
        return;
      }
      if (!(await this.$refs.address.$refs.form.validate()).valid) {
        this.tab = '2';
        return;
      }

      this.personSend();
    },
  },
};
</script>
