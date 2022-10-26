<template>
  <v-navigation-drawer
    v-model="mini"
    permanent
    :rail="interfaceStore.menuOpen"
    expand-on-hover
  >
    <v-list dense>
      <template v-for="item in items" :key="item.title">
        <template v-if="item.group">
          <v-list-group
            :value="item.title"
            color="primary"
            expand-icon="fa-solid fa-sort-down fa-sm"
            collapse-icon="fa-solid fa-sort-up fa-sm"
          >
            <template #activator="{ props }">
              <v-list-item
                v-bind="props"
                :prepend-icon="item.icon"
                :title="item.title"
              ></v-list-item>
            </template>

            <TheMenuItem
              v-for="ii in item.items"
              :key="ii.title"
              :item="ii"
              variant="tonal"
            ></TheMenuItem>
          </v-list-group>
        </template>
        <TheMenuItem v-else :item="item"></TheMenuItem>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { useInterfaceStore } from "~/stores";
import TheMenuItem from "~/components/layout/TheMenuItem.vue";

export default {
  name: "TheMainMenu",
  components: { TheMenuItem },
  setup() {
    const interfaceStore = useInterfaceStore();
    return { interfaceStore };
  },
  data() {
    return {
      mini: true,
      items: [
        {
          group: true,
          icon: "fa fa-person",
          title: "Person",
          items: [{ title: "Individual", routeName: "PersonList" }],
        },
        { title: "Home", icon: "fa fa-home" },
        { title: "Users", icon: "fa fa-user", routeName: "usersList" },
      ],
    };
  },
};
</script>
