<template>
  <v-autocomplete
    v-model:search="search"
    :label="label as string"
    :rules="rules as []"
    :clearable="true"
    :items="items"
    :loading="loading"
    :item-title="(item) => {return item.name + ' ' + item.surname}"
    item-value="id"
    return-object
    density="compact"
    variant="underlined"
    @input="searchItems"
  />
</template>

<script lang="ts">
import {defineComponent, inject, ref} from 'vue';
import type {IConfigVars} from "~/@types/vue";

export default defineComponent({
  name: 'ThePersonAutocomplete',
  props: {
    modelValue: {type: String},
    label: {type: String, required: true},
    required: {type: Boolean, default: false},
    rules: {type: Array, required: false},
    endPoint: {type: String, required: true},
  },
  async setup(props) {
    const configVars = inject('configVars') as IConfigVars;

    const DATA = {
      descriptionLimit: 60,
      loading: ref(false),
      items: ref([]),
      search: ref(''),
    }

    const METHODS = {
      searchItems: async function () {
        if (DATA.loading.value || !DATA.search.value) return;
        DATA.loading.value = true;

        configVars.$http
          .get(`${configVars.$apiUrl}/api/${props.endPoint}`, {
            params: {name: DATA.search.value},
          })
          .then(d => {
            DATA.items.value = d.data.data;
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            DATA.loading.value = false;
          });
      },
    }
    return {...DATA, ...METHODS}
  },
});
</script>
