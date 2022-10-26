<template>
  <Datepicker
    v-model="dateModel"
    auto-apply
    text-input
    model-type="dd/MM/yyyy"
    dark
    :required="required"
    :enable-time-picker="!hours"
  >
    <template #dp-input>
      <v-text-field
        v-model="dateModel"
        :rules="[(v) => required === false || !!v || 'Item is required']"
        :label="label"
        :required="required"
      ></v-text-field>
    </template>
  </Datepicker>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import { mask } from "vue-the-mask";
import { useModelWrapper } from "~/helpers";

export default {
  name: "TheDatepicker",
  components: { Datepicker },
  directives: { mask },
  props: {
    modelValue: String,
    hours: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
    label: String,
  },
  emits: ["update:modelValue"],
  setup(props, { emit }) {
    return {
      dateModel: useModelWrapper(props, emit, "modelValue"),
    };
  },
};
</script>
