<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="6">
        <v-text-field
          v-model="person.name"
          :rules="[(v) => !!v || 'Item is required']"
          label="Name"
          required
        />
      </v-col>

      <v-col cols="6">
        <v-text-field
          v-model="person.surname"
          :rules="[(v) => !!v || 'Item is required']"
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
          :rules="[(v) => !!v || 'Item is required']"
          label="NIF"
          required
        />
      </v-col>
      <v-col cols="4">
        <v-text-field
          v-model="person.secondaryDocument"
          :rules="[(v) => !!v || 'Item is required']"
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
</template>

<script>
import { usePersonStore } from "~/stores";
import { mask } from "vue-the-mask";
import { TheDatepicker } from "~/components";

export default {
  name: "PortugalIndividualPersonForm",
  directives: { mask },
  components: { TheDatepicker },
  async setup() {
    const personStore = usePersonStore();
    const person = personStore.person;
    personStore.person.individual = true;
    return { person };
  },
};
</script>
