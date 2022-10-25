<template>
  {{ internalModel }}
  <Datepicker
    v-model="internalModel"
    auto-apply
    text-input
    model-type="dd/MM/yyyy"
    dark
    :required="required"
    :enable-time-picker="!hours"
  >
    <template #dp-input>
      <v-text-field
        v-model="internalModel"
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
import { useVModel } from "@vueuse/core";

export default {
  name: "TheDatepicker",
  components: { Datepicker },
  directives: { mask },
  props: {
    modelValue: { type: Date },
    hours: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
  },
  emits: ["update:modelValue"],
  setup() {
    const emit = defineEmits(["update:modelValue"]);
    const model = useVModel(props, "modelValue", emit);
  },
  computed: {
    internalModel: {
      get: function () {
        return this.model;
      },
      set: function (e) {
        console.log(e);
        this.$emit("update:modelValue", e);
      },
    },
  },
};
</script>
