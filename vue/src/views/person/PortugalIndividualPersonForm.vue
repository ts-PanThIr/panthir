<template>
  <v-form
      ref="form"
  >
    <v-row>
      <v-col cols="6">
        <v-text-field
            v-model="person.name"
            :rules="[v => !!v || 'Item is required']"
            label="Name"
            required
        ></v-text-field>
      </v-col>

      <v-col cols="6">
        <v-text-field
            v-model="person.surname"
            :rules="[v => !!v || 'Item is required']"
            label="Surname"
            required
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="4" >
        <Datepicker
            v-model="person.birthdate"
            autoApply
        >
          <template #dp-input="{ value, onInput, onEnter, onTab, onClear }">
            <v-text-field
                :value="value"
                :rules="[v => !!v || 'Item is required']"
                label="Birthdate"
                required
            ></v-text-field>
          </template>
        </Datepicker>
      </v-col>
      <v-col cols="4" >
        <v-text-field
            v-model="person.nif"
            :rules="[v => !!v || 'Item is required']"
            label="NIF"
            v-mask="'###.###.###'"
            required
        ></v-text-field>
      </v-col>
      <v-col cols="4" >
        <v-text-field
            v-model="person.niss"
            :rules="[v => !!v || 'Item is required']"
            label="NISS"
            required
        ></v-text-field>
      </v-col>
    </v-row>

    <v-textarea
        v-model="person.AdditionInformation"
        label="Addition information"
    >
    </v-textarea>

  </v-form>
</template>

<script>
import {usePersonStore} from "~/stores";
import {mask} from 'vue-the-mask';
import Datepicker from '@vuepic/vue-datepicker';

export default {
  name: "PortugalIndividualPersonForm",
  directives: {mask},
  components: {Datepicker},
  async setup() {
    const personStore = usePersonStore();
    const person = personStore.person;
    return { person };
  },
}
</script>