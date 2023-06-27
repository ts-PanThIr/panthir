<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Individual person"
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
            :to="{ name: 'personNew' }"
          />
        </v-col>
      </template>
    </the-card-title>
    <v-card-text>
      <base-grid
        v-model:page="page"
        v-model:limit="limit"
        :matrix="people"
        :header="headers"
        @update:limit="updateList()"
        @update:page="updateList()"
      >
        <template #action="{ element }">
          <td class="actions to-none pa-1">
            <v-btn
              color="primary"
              size="x-small"
              icon="fa fa-pencil"
              :to="{ name: 'personEdit', params: { id: element.id } }"
            />
          </td>
        </template>
      </base-grid>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import {defineComponent, ref} from 'vue';
import {BaseGrid, TheCardTitle} from '~/components';
import {usePersonStore} from '~/stores';
import {storeToRefs} from "pinia";

export default defineComponent({
  name: 'PersonListView',
  components: {BaseGrid, TheCardTitle},
  async setup() {
    const data = {
      limit: ref(10),
      page: ref(1),
      headers: {
        action: '#',
        id: 'Id',
        name: 'Name',
        surname: 'Surname',
        document: 'NIF',
        birthDate: 'Birth date',
      },
      search: null,
    };
    const personStore = usePersonStore();
    await personStore.getAll({limit: data.limit.value, page: data.page.value});
    const {list: people} = storeToRefs(personStore);
    return {people, ...data};
  },
  unmounted() {
    const personStore = usePersonStore();
    personStore.$reset()
  },
  methods: {
    updateList: async function () {
      const personStore = usePersonStore();
      await personStore.getAll(
        {limit: this.limit, page: this.page}
      );
    },
  }
});
</script>
