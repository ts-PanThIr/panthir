<template>
  <v-row>
    <v-col cols="9">
      <v-text-field
        :rules="[(v) => required === false || !!v || 'Item is required']"
        label="Person"
        :required="required"
      ></v-text-field>
    </v-col>

    <v-col cols="3">
      <v-text-field
        readonly
        :rules="[(v) => required === false || !!v || 'Item is required']"
        label="Code"
        :required="required"
      ></v-text-field>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "ThePersonAutocomplete",
  props: {
    modelValue: String,
    hours: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
    label: String,
  },
};
</script>
