<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Person"
      icon="fas fa-person"
      bg-color="bg-success-gradient"
      text-color="white"
    >
      <template #after>
        <v-col cols="6" class="pa-0 d-flex justify-end">
          <v-tabs
            v-model="tab"
            class="bg-success-gradient position-absolute rounded mt-n5 mb-3"
            stacked
            grow
          >
            <v-tab value="1">
              <em class="fas fa-person" />
              <small class="pt-1">Who</small>
            </v-tab>
            <v-tab value="2">
              <em class="fas fa-address-book" />
              <small class="pt-1">Address</small>
            </v-tab>
            <v-tab value="3">
              <em class="fas fa-mobile-alt" />
              <small class="pt-1">Contact</small>
            </v-tab>
          </v-tabs>
        </v-col>
      </template>
    </the-card-title>
    <v-window v-model="tab">
      <v-window-item value="1" eager>
        <v-card-text>
          <v-form ref="personForm">
            <v-row>
              <v-col cols="6">
                <v-text-field
                  v-model="person.name"
                  :rules="[v => !!v || 'Item is required']"
                  label="Name"
                  required
                />
              </v-col>

              <v-col cols="6">
                <v-text-field
                  v-model="person.surname"
                  :rules="[v => !!v || 'Item is required']"
                  label="Surname"
                  required
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="4">
                <TheDatepicker
                  v-model="person.birthDate"
                  hours
                  label="Birthdate"
                />
              </v-col>
              <v-col cols="4">
                <v-text-field
                  v-model="person.document"
                  v-mask="'###.###.###'"
                  :rules="[v => !!v || 'Item is required']"
                  label="NIF"
                  required
                />
              </v-col>
              <v-col cols="4">
                <v-text-field
                  v-model="person.secondaryDocument"
                  :rules="[v => !!v || 'Item is required']"
                  label="NISS"
                  required
                />
              </v-col>
            </v-row>

            <v-textarea
              v-model="person.AdditionInformation"
              label="Addition information"
            />
          </v-form>
        </v-card-text>
      </v-window-item>
      <v-window-item value="2" eager>
        <v-card-text>
          <TheAddressAddList ref="address" />
        </v-card-text>
      </v-window-item>
      <v-window-item value="3" eager>
        <v-card-text>
          <TheContactAddList ref="contact" />
        </v-card-text>
      </v-window-item>
    </v-window>
    <v-container fluid class="justify-end d-flex">
      <v-btn class="success" @click="validate"> Send </v-btn>
    </v-container>
  </v-card>
</template>

<script>
import { usePersonStore } from '~/stores';
import { useRoute } from 'vue-router';
import {
  TheAddressAddList,
  TheContactAddList,
  TheCardTitle,
  TheDatepicker,
} from '~/components';
import { mask } from 'vue-the-mask';

export default {
  name: 'PersonEditView',
  components: {
    TheContactAddList,
    TheAddressAddList,
    TheCardTitle,
    TheDatepicker,
  },
  directives: { mask },
  async setup() {
    const route = useRoute();
    const personStore = usePersonStore();
    if (route.name !== 'personNew') {
      await personStore.getOne(route.params.id);
    }
    const { person, send: personSend } = personStore
    return { person, personStore, personSend };
  },
  data: () => ({
    tab: null,
    name: '',
    checkbox: false,
  }),

  methods: {
    validate: async function () {
      if (!(await this.$refs.personForm.validate()).valid) {
        this.tab = '1';
        return;
      }
      if (!(await this.$refs.address.$refs.form.validate()).valid) {
        this.tab = '2';
        return;
      }
      if (!(await this.$refs.contact.$refs.form.validate()).valid) {
        this.tab = '3';
        return;
      }

      const person = await this.personSend();
      this.$router.push({name: 'personEdit', params: {id: person.id}})
      
    },
  },
};
</script>
