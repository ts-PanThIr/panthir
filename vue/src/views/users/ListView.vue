<template>
  <h1>Users</h1>
  <router-link to="/users/add" class="btn btn-sm btn-success mb-2">
    Add User
  </router-link>

  <base-grid
    :tags="tags"
    :page="page"
    :limit="limit"
    class="collaborators-table"
    :matrix="users"
    :formatter="formatter"
    :header="headers"
  >
    <template #action="{ element, index }">
      <td class="actions to-none pa-lg-3" data-label="Actions :">
        <button title="Détails" @click="clicked(element, index)">
          <i class="fas fa-search"></i>
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
  async setup() {
    const usersStore = useUsersStore();
    await usersStore.getAll();
    const users = usersStore.users;
    return { users };
  },
  components: { BaseGrid },
  data: () => ({
    limit: "tout",
    page: 1,
    tags: [],
    formatter: {
      createdAt: "date",
      lastLoginAt: "date",
    },
    headers: {
      budgetCodes: "Code budgets",
      lastName: "Nom",
      firstName: "Prénom",
      employeeId: "Matricule",
      email: "Email",
      createdAt: "Date de création",
      lastLoginAt: "Dernière connexion",
      action: "Actions",
    },
    search: null,
  }),
};
</script>
