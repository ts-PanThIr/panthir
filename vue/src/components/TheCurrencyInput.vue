<template>
  <v-text-field
    ref="inputRef"
    v-model="valueModel"
    :label="label"
  ></v-text-field>
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";
import { computed } from "vue";

export default {
  name: "TheCurrencyInput",
  props: {
    modelValue: Number,
    options: Object,
    label: String,
  },
  emits: ["update:modelValue"],
  setup(props, { emit }) {
    const { inputRef, numberValue } = useCurrencyInput(
      { currency: "EUR", autoDecimalDigits: true },
      false
    );

    return {
      inputRef,
      valueModel: computed({
        get: () => props.modelValue,
        set: () => emit(`update:modelValue`, numberValue),
      }),
    };
  },
};
</script>
