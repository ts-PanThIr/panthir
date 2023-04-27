<template>
  <v-autocomplete
    v-model:search="search"
    label="Person"
    :rules="rules"
    clearable
    :items="items"
    :loading="loading"
    item-title="name"
    item-value="id"
    return-object
    @input="searchItems"
  />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: 'ThePersonAutocomplete',
  props: {
    modelValue: String,
    label: String,
    hours: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    rules: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      descriptionLimit: 60,
      loading: false,
      items: [],
      model: null,
      search: '',
    };
  },
  methods: {
    searchItems: async function () {
      if (this.loading || !this.search) return;
      this.loading = true;

      axios
        .get(`${this.configVars.$apiUrl}/api/person/`, {
          params: { name: this.search },
        })
        .then(d => {
          this.items = d.data.data;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
});
</script>
