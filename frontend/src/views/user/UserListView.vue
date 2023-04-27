<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Users"
      icon="fa fa-person"
      bg-color="bg-secondary-gradient"
      text-color="white"
    >
      <template #after>
        <v-col cols="6" class="pa-0 d-flex justify-end">
          <v-btn
            rounded
            icon="fas fa-plus"
            class="bg-success-gradient position-absolute mt-n5 mb-3 text-white icon-fix"
            :to="{ name: 'usersNew' }"
          />
        </v-col>
      </template>
    </the-card-title>

    <v-card-text>
      <base-grid
        v-model:page="page"
        v-model:limit="limit"
        class="collaborators-table"
        :matrix="users"
        :header="headers"
      >
        <template #action="{ element }">
          <td class="actions to-none pa-1">
            <v-btn
              color="primary"
              size="x-small"
              icon="fa fa-pencil"
              :to="{ name: 'usersEdit', params: { id: element.id } }"
            />
          </td>
        </template>

        <template
          v-for="slotName in ['123', 'asd', 'dfasd']"
          #[slotName]="{ text }"
          :key="slotName"
        >
          <td>
            <span class="font-weight-bold">{{ text ? text : '-' }}</span>
          </td>
        </template>
      </base-grid>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import { BaseGrid, TheCardTitle } from '~/components';
import { useUsersStore } from '~/stores';
import { defineComponent, ref } from 'vue';

export default defineComponent({
  components: { BaseGrid, TheCardTitle },
  async setup() {
    const usersStore = useUsersStore();
    await usersStore.getAll();
    const users = usersStore.list;

    const data = {
      limit: ref(50),
      page: ref(1),
      headers: {
        action: '#',
        id: 'Id',
        email: 'Email',
      },
      search: null,
    }

    return { users, ...data };
  },
  unmounted() {
    const store = useUsersStore()
    store.$reset()
  },  
});
</script>
