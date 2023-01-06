<template>
  <h1>Users</h1>
  <router-link
    to="/users/add"
    class="btn btn-sm btn-success mb-2"
  >
    Add User
  </router-link>

  <base-grid
    v-model:page="page"
    v-model:limit="limit"
    class="collaborators-table"
    :matrix="users"
    :header="headers"
  >
    <template #action="{ element, index }">
      <td
        class="actions to-none pa-lg-3"
        data-label="Actions :"
      >
        <button
          title="Détails"
          @click="clicked(element, index)"
        >
          <i class="fas fa-search" />
        </button>
      </td>
    </template>

    <template
      v-for="slotName in ['budgetCodes', 'lastName', 'firstName']"
      #[slotName]="{ text }"
      :key="slotName"
    >
      <td>
        <span class="font-weight-bold">{{ text ? text : "-" }}</span>
      </td>
    </template>
  </base-grid>
</template>

<script>
import { BaseGrid } from "~/components";
import { useUsersStore } from "~/stores";

export default {
  components: { BaseGrid },
  async setup() {
    const usersStore = useUsersStore();
    await usersStore.getAll();
    const users = usersStore.users;
    return { users };
  },
  data: () => ({
    limit: "All",
    page: 1,
    headers: {
      id: "Id",
      email: "Email",
    },
    search: null,
  }),
};
</script>
