<template>
  <v-text-field
    ref="inputRef"
    v-model="dateModel"
    :color="color"
    :label="label"
    :readonly="readonly"
    :rules="rules"
    @focus="focused = true"
    @blur="focused = false"
    @keydown="isNumber($event)"
  />
</template>

<script>
export default {
  name: 'TheCurrencyInput',
  props: {
    modelValue: Number,
    label: String,
    color: String,
    readonly: { type: Boolean, default: false },
    rules: {
      type: Array,
      required: false,
    },
  },
  emits: ['update:modelValue'],
  data() {
    return {
      focused: false,
    };
  },
  computed: {
    dateModel: {
      get: function () {
        if (this.focused) {
          return this.modelValue;
        }
        return Intl.NumberFormat('pt-PT', {
          style: 'currency',
          currency: 'EUR',
        }).format(this.modelValue);
      },
      set: function (e) {
        const thousandSeparator = Intl.NumberFormat('pt-PT')
          .format(11111)
          .replace(/\p{Number}/gu, '');
        const decimalSeparator = Intl.NumberFormat('pt-PT')
          .format(1.1)
          .replace(/\p{Number}/gu, '');

        let decimal = parseFloat(
          e
            .replace(new RegExp('\\' + thousandSeparator, 'g'), '')
            .replace(new RegExp('\\' + decimalSeparator), '.'),
        );
        if (isNaN(decimal)) decimal = 0;
        this.$emit(`update:modelValue`, Number(decimal.toFixed(2)));
      },
    },
  },
  methods: {
    isNumber: function (e) {
      const keysAllowed = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '.',
        'Tab',
        'Escape',
        'Backspace',
        'Delete',
      ];
      const keyPressed = e.key;

      if (!keysAllowed.includes(keyPressed)) {
        e.preventDefault();
      }
    },
  },
};
</script>
