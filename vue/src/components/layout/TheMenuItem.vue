<template>
  <v-list-item :key="item.title" link :to="{ name: item.routeName }">
    <template v-if="item.icon" #prepend>
      <v-icon :icon="item.icon" size="small"></v-icon>
    </template>
    <v-list-item-title v-text="item.title"></v-list-item-title>
  </v-list-item>
</template>

<script>
export default {
  name: "TheMenuItem",
  props: {
    item: {
      type: Object,
    },
  },
};
</script>
