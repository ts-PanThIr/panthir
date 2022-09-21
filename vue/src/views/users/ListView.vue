<script setup>
import { useUsersStore } from "~/stores";

const usersStore = useUsersStore();
const users = usersStore.getAll();
console.log(users)
</script>

<template>
  <h1>Users</h1>
  <router-link to="/users/add" class="btn btn-sm btn-success mb-2">Add User</router-link>

  <base-grid
      class="collaborators-table"
      :matrix="users"
      :formatter="formatter"
      :header="headers"
      :tags.sync="tags"
      :page.sync="page"
      :limit.sync="limit"
      @updateSearch="getVaultUsers"
  >
    <template v-slot:action="{ element, index }">
      <td class="actions to-none pa-lg-3" data-label="Actions :">
        <button title="Détails" @click="clicked(element, index)"><i class="fas fa-search"></i></button>
      </td>
    </template>

    <template v-slot:[slotName]="{ text }" v-for="slotName in ['budgetCodes', 'lastName', 'firstName']">
      <td :key="slotName"><span class="font-weight-bold">{{ text ? text : '-' }}</span></td>
    </template>
  </base-grid>

  <table class="table table-striped">
    <thead>
      <tr>
        <th style="width: 30%">First Name</th>
        <th style="width: 30%">Last Name</th>
        <th style="width: 30%">Username</th>
        <th style="width: 10%"></th>
      </tr>
    </thead>
    <tbody>
      <template v-if="users.length">
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.firstName }}</td>
          <td>{{ user.lastName }}</td>
          <td>{{ user.username }}</td>
          <td style="white-space: nowrap">
            <router-link
              :to="`/users/edit/${user.id}`"
              class="btn btn-sm btn-primary mr-1"
              >Edit</router-link
            >
            <button
              class="btn btn-sm btn-danger btn-delete-user"
              :disabled="user.isDeleting"
              @click="usersStore.delete(user.id)"
            >
              <span
                v-if="user.isDeleting"
                class="spinner-border spinner-border-sm"
              ></span>
              <span v-else>Delete</span>
            </button>
          </td>
        </tr>
      </template>
      <tr v-if="users.loading">
        <td colspan="4" class="text-center">
          <span class="spinner-border spinner-border-lg align-center"></span>
        </td>
      </tr>
      <tr v-if="users.error">
        <td colspan="4">
          <div class="text-danger">Error loading users: {{ users.error }}</div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import {BaseGrid} from "~/components";

export default {
  components: { BaseGrid },
  data: () => ({
    limit: 'tout',
    page: 1,
    tags: [],
    formatter: {
      createdAt: 'date',
      lastLoginAt: 'date'
    },
    headers: {
      budgetCodes: 'Code budgets',
      lastName: 'Nom',
      firstName: 'Prénom',
      employeeId: 'Matricule',
      email: 'Email',
      createdAt: 'Date de création',
      lastLoginAt: 'Dernière connexion',
      action: 'Actions'
    }
  }),
}
</script>