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
      <v-btn
        icon
        color="white"
        text
        @click="snackbar = false"
      >
        <i class="fa fa-times" />
      </v-btn>
    </template>
  </v-snackbar>
</template>
<script>
import {useNotificationStore} from '~/stores';

export default {
  name: 'TheNotification',
  props: {
    text: String,
    title: String,
    lastId: Number,
    type: {
      type: String,
      default: 'info',
      validator: value => {
        const acceptedValues = [
          'info',
          'primary',
          'danger',
          'warning',
          'success',
        ]
        return acceptedValues.indexOf(value) !== -1
      },
    },
    timeout: {
      type: Number,
      default: 5000,
    },
  },
  setup: async function () {
    const notificationStore = useNotificationStore();
    const removeMessage = notificationStore.removeMessage;
    return { removeMessage };
  },
  data () {
    return {
      snackbar: true,
    }
  },
  watch: {
    snackbar: function (e) {
      if (!e) {
        this.removeMessage(this.lastId)
      }
    },
  },
}
</script>

