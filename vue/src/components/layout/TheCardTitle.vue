<template>
  <v-card-title class="mt-4 mb-5">
    <div
      v-if="icon"
      class="icon-wrapper text-center rounded-lg mt-n5 position-absolute d-flex align-center justify-center"
      :class="bgColor"
    >
      <v-icon :icon="icon" :color="textColor"></v-icon>
    </div>
    <h3 class="pl-16 ml-3">{{ text }}</h3>
  </v-card-title>
</template>

<script>
export default {
  name: "TheCardTitle",
  props: {
    icon: String,
    text: String,
    bgColor: {
      Type: String,
      default() {
        return "bg-primary";
      },
    },
    textColor: {
      Type: String,
      default() {
        return "grey-darken-4";
      },
    },
  },
};
</script>
