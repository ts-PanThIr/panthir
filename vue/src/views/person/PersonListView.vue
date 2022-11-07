<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Individual person"
      icon="fa fa-person"
      bg-color="bg-secondary"
      text-color="white"
    ></the-card-title>
    <v-card-text>
      <base-grid
        v-model:page="page"
        v-model:limit="limit"
        :matrix="people"
        :header="headers"
      >
        <template #action="{ element }">
          <td class="actions to-none pa-lg-3">
            <v-btn
              color="primary"
              size="x-small"
              icon="fa fa-pencil"
              :to="{ name: 'personEdit', params: { id: element.id } }"
            >
            </v-btn>
          </td>
        </template>
      </base-grid>
    </v-card-text>
  </v-card>
</template>

<script>
import { BaseGrid, TheCardTitle } from "~/components";
import { usePersonStore } from "~/stores";

export default {
  name: "PersonListView",
  components: { BaseGrid, TheCardTitle },
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
      action: "#",
      id: "Id",
      name: "Name",
      surname: "Surname",
      document: "NIF",
      birthDate: "BirthDate",
    },
    search: null,
  }),
};
</script>
