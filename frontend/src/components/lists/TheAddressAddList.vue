<template>
  <div class="wrapper">
    <v-form ref="form">
      <v-row class="justify-center">
        <v-btn class="info" @click="addAddress()"> New</v-btn>
      </v-row>
      <v-row
        v-for="(item, index) in addresses"
        :key="index"
        :class="index % 2 !== 0 ? 'bg-surfaceLighten' : ''"
        class="py-4"
      >
        <v-col cols="2" class="d-flex justify-center align-center flex-column">
          <v-btn
            size="small"
            icon="fa fa-times"
            color="error"
            @click="deleteAddress(index)"
          />
        </v-col>
        <v-col cols="10">
          <v-row>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.name"
                :rules="[v => !!v || 'Item is required']"
                label="Name"
                required
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.zip"
                v-mask="'#####-###'"
                label="Zip"
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.country"
                :rules="[v => !!v || 'Item is required']"
                label="Country"
                density="compact"
                required
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.district"
                :rules="[v => !!v || 'Item is required']"
                label="District"
                required
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.city"
                :rules="[v => !!v || 'Item is required']"
                label="City"
                required
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.address"
                :rules="[v => !!v || 'Item is required']"
                label="Address"
                required
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.addressComplement"
                label="Complement"
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="3">
              <v-text-field
                v-model="item.number"
                label="Number"
                density="compact"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-form>
  </div>
</template>

<script lang="ts">
import {mask} from 'vue-the-mask';
import {useAddressStore} from '~/stores';
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'TheAddressAddList',
  directives: {mask},
  setup: async function () {
    const addressStore = useAddressStore();
    const addresses = addressStore.list;
    const deleteAddress = addressStore.delete;
    const addAddress = addressStore.createNewItem;
    return {addresses, deleteAddress, addAddress};
  },
  unmounted() {
    const store = useAddressStore()
    store.$reset()
  },
});
</script>
