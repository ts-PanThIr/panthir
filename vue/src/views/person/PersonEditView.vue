<template>
  <v-card>
    <v-tabs
        v-model="tab"
        class="bg-accent mb-3"
        stacked
        color="white"
        grow
    >
      <v-tab value="one">
        <em class="fas fa-person"></em>
        <small class="pt-1">Who</small>
      </v-tab>
      <v-tab value="two">
        <em class="fas fa-address-book"></em>
        <small class="pt-1">Address</small>
      </v-tab>
      <v-tab value="three">
        <em class="fas fa-mobile-alt"></em>
        <small class="pt-1">Phone</small>
      </v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item value="one">
        <v-card-text>
          <PortugalIndividualPersonForm v-model:valid="valid" ></PortugalIndividualPersonForm>
        </v-card-text>
      </v-window-item>
    </v-window>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="validate"
          align="right"
      >
        Validate
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import PortugalIndividualPersonForm from "~/views/person/PortugalIndividualPersonForm.vue";
import { usePersonStore } from "~/stores";
import { useRoute } from 'vue-router'

export default {
  name: "PersonEditView",
  components: { PortugalIndividualPersonForm },
  async setup() {
    const route = useRoute();
    const personStore = usePersonStore();
    if(route.name !== "PersonNew") {
      await personStore.getAll();
    }
    const person = personStore.person;
    return { person };
  },
  data: () => ({
    valid: true,
    tab: null,
    name: '',
    checkbox: false,
  }),

  methods: {
    validate() {
      this.$refs.form.validate()
    },
  },
}
</script>