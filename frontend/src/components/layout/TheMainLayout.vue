<template>
  <TheMainAppBar />

  <TheMainMenu />

  <v-main ref="mainView">
    <v-container ref="mainContainer" fluid>
      <router-view v-slot="{ Component, route }" name="default">
        <transition
          :key="route.path"
          :name="route.meta.transition as string"
          mode="out-in"
          :duration="300"
        >
          <suspense>
            <template #default>
              <component :is="Component" :key="route.path" />
            </template>
            <template #fallback>
              <the-spinner :height="containerHeight + 'px'"></the-spinner>
            </template>
          </suspense>
        </transition>
      </router-view>
      <suspense>
        <the-notifications />
      </suspense>
    </v-container>
  </v-main>
</template>

<script lang="ts">
import { TheMainAppBar, TheMainMenu } from '~/components';
import TheNotifications from './TheNotifications.vue';
import { ref, defineComponent } from 'vue';
import type { VContainer } from 'vuetify/components';

export default defineComponent({
  name: 'TheMainLayout',
  components: { TheMainAppBar, TheMainMenu, TheNotifications },
  setup() {
    const data = {
      mainContainer: ref(null),
      containerHeight: ref(0),
    };
    return { ...data };
  },
  mounted() {
    this.containerHeight =
      (this.mainContainer as unknown as typeof VContainer).$vuetify.display
        .height - 152;
  },
});
</script>
