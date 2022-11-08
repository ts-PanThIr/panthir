<template>
  <v-card>
    <v-tabs v-model="tab" class="bg-accent mb-3" stacked color="white" grow>
      <v-tab value="1">
        <em class="fas fa-person"></em>
        <small class="pt-1">Title</small>
      </v-tab>
      <v-tab value="2">
        <em class="fas fa-address-book"></em>
        <small class="pt-1">Movement</small>
      </v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item value="1" eager>
        <v-card-text>
          <financial-title-form></financial-title-form>
        </v-card-text>
      </v-window-item>
      <v-window-item value="2" eager>
        <v-card-text> dasdasdasd </v-card-text>
      </v-window-item>
    </v-window>
    <v-container fluid class="justify-end d-flex">
      <v-btn color="success" @click="validate"> Send</v-btn>
    </v-container>
  </v-card>
</template>

<script>
import { usePersonStore } from "~/stores";
import { useRoute } from "vue-router";
import { FinancialTitleForm } from "~/views/components";

export default {
  name: "FinancialEditView",
  components: { FinancialTitleForm },
  async setup() {
    const route = useRoute();
    const personStore = usePersonStore();
    if (route.name !== "PersonNew") {
      // await personStore.getOne(route.params.id);
    }
    const person = personStore.person;
    const personSend = personStore.send;
    return { person, personStore, personSend };
  },
  data: () => ({
    tab: null,
  }),

  methods: {
    validate: async function () {
      return false;

      if (!(await this.$refs.personIndividual.$refs.form.validate()).valid) {
        this.tab = "1";
        return;
      }
      if (!(await this.$refs.address.$refs.form.validate()).valid) {
        this.tab = "2";
        return;
      }

      this.personSend();
    },
  },
};
</script>
