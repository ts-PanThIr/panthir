<template>
  <Datepicker
    v-model="model"
    auto-apply
    text-input
    modelType="dd/MM/yyyy"
    dark
    :required="required"
    :enableTimePicker="!hours"
  >
    <template #dp-input>
      <v-text-field
        v-model="model"
        :rules="[(v) => required === false || !!v || 'Item is required']"
        label="Birthdate"
        :required="required"
      ></v-text-field>
    </template>
  </Datepicker>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import { mask } from "vue-the-mask";

export default {
  name: "TheDatepicker",
  components: { Datepicker },
  directives: { mask },
  props: {
    model: { type: Date },
    hours: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
  },
};
</script>
