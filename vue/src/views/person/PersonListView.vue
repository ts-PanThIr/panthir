<template>
  <base-grid
    v-model:page="page"
    v-model:limit="limit"
    :matrix="people"
    :header="headers"
  ></base-grid>
</template>

<script>
import { BaseGrid } from "~/components";
import { usePersonStore } from "~/stores";

export default {
  name: "PersonListView",
  components: { BaseGrid },
  async setup() {
    const personStore = usePersonStore();
    await personStore.getAll();
    const people = personStore.list;
    return { people };
  },
  data: () => ({
    limit: "All",
    page: 1,
    headers: {
      name: "Name",
    },
    search: null,
  }),
};
</script>
