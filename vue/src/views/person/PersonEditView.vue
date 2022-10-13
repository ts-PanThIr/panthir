<template>
  <v-card>
    <v-tabs v-model="tab" class="bg-accent mb-3" stacked color="white" grow>
      <v-tab value="1">
        <em class="fas fa-person"></em>
        <small class="pt-1">Who</small>
      </v-tab>
      <v-tab value="2">
        <em class="fas fa-address-book"></em>
        <small class="pt-1">Address</small>
      </v-tab>
      <v-tab value="3">
        <em class="fas fa-mobile-alt"></em>
        <small class="pt-1">Phone</small>
      </v-tab>
    </v-tabs>
    <KeepAlive>
      <v-window v-model="tab">
        <v-window-item value="1" eager>
          <v-card-text>
            <PortugalIndividualPersonForm
              ref="personIndividual"
            ></PortugalIndividualPersonForm>
          </v-card-text>
        </v-window-item>
        <v-window-item value="2" eager>
          <v-card-text>
            <TheAddressAddList
                ref="address"
            ></TheAddressAddList>
          </v-card-text>
        </v-window-item>
      </v-window>
    </KeepAlive>
    <v-container fluid class="justify-end d-flex">
      <v-btn
        color="success"
        @click="validate"
      >
        Validate
      </v-btn>
    </v-container>
  </v-card>
</template>

<script>
import PortugalIndividualPersonForm from "~/views/person/PortugalIndividualPersonForm.vue";
import { usePersonStore } from "~/stores";
import { useRoute } from "vue-router";
import {TheAddressAddList} from "~/components";

export default {
  name: "PersonEditView",
  components: { PortugalIndividualPersonForm, TheAddressAddList },
  async setup() {
    const route = useRoute();
    const personStore = usePersonStore();
    if (route.name !== "PersonNew") {
      await personStore.getAll();
    }
    const person = personStore.person;
    return { person, personStore };
  },
  data: () => ({
    tab: null,
    name: "",
    checkbox: false,
  }),

  methods: {
    validate: async function () {
      if (!(await this.$refs.personIndividual.$refs.form.validate()).valid){
        this.tab = "1";
        return;
      }
      if (!(await this.$refs.address.$refs.form.validate()).valid) {
        this.tab = "2";
        return;
      }

      this.send()
    },
    send: function() {
      console.log("aee")
    }
  },
};
</script>
