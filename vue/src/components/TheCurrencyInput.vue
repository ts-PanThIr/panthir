<template>
  <v-text-field
    ref="inputRef"
    v-model="modelValue"
    :label="label"
    :readonly="readonly"
  ></v-text-field>
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";

export default {
  name: "TheCurrencyInput",
  props: {
    modelValue: Number,
    options: Object,
    label: String,
    readonly: { type: Boolean, default: false },
  },
  emits: ["update:modelValue"],
  setup() {
    const { inputRef, formattedValue, numberValue } = useCurrencyInput(
      { currency: "EUR", autoDecimalDigits: true },
      false
    );
    console.log(formattedValue.value);
    return {
      inputRef,
      numberValue,
    };
  },
};
</script>
