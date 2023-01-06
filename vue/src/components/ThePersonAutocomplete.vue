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

<script>
export default {
  name: "ThePersonAutocomplete",
  props: {
    modelValue: String,
    hours: { type: Boolean, default: false },
    required: { type: Boolean, default: false },
    label: String,
    rules: {
      type: Array,
      required: false,
    },
  },
  data () {
    return {
      descriptionLimit: 60,
      loading: false,
      items: [],
      model: null,
      search: null,
    }
  },
  methods: {
    searchItems: async function () {
      if (this.loading || !this.search) return
      this.loading = true

      const path = `${this.$apiUrl}/api/person/`;
      this.$http
        .get(path, { params: { name: this.search } } )
        .then((d) => { this.items = d.data.data })
        .catch((error) => { console.log(error) })
        .finally(() => { this.loading = false })
    },
  },
};
</script>
