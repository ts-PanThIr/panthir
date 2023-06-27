<template>
  <v-snackbar
    v-model="snackbar"
    :timeout="timeout"
    tile
    contained
    :color="type"
    :multi-line="false"
    location="right bottom"
  >
    <template #default>
      {{ text }}
    </template>

    <template #actions>
      <v-btn icon color="white" text @click="snackbar = false">
        <i class="fa fa-times" />
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {EMessageType, useNotificationStore} from '~/stores';

export default defineComponent({
  name: 'TheNotification',
  props: {
    text: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: '',
    },
    lastId: {
      type: Number,
      required: true,
    },
    type: {
      type: String,
      default: 'info',
      validator: (value: string) => {
        const acceptedValues: string[] = Object.values(EMessageType);
        return acceptedValues.indexOf(value) !== -1;
      },
    },
    timeout: {
      type: Number,
      default: 5000,
    },
  },
  data() {
    return {
      snackbar: true,
    };
  },
  watch: {
    snackbar(e: boolean) {
      if (!e) {
        const { removeMessage } = useNotificationStore();
        removeMessage(this.lastId);
      }
    },
  },
});
</script>
