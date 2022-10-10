<template>
  <div class="wrapper">
    <v-form ref="form">
      <v-row>
        <v-col cols="3" sm="6">
          <v-text-field
              :rules="[(v) => !!v || 'Item is required']"
              label="Name"
              required
              density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              label="Zip"
              density="compact"
              v-mask="'#####-###'"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              :rules="[(v) => !!v || 'Item is required']"
              label="Country"
              density="compact"
              required
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              :rules="[(v) => !!v || 'Item is required']"
              label="District"
              required
              density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              :rules="[(v) => !!v || 'Item is required']"
              label="City"
              required
              density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              :rules="[(v) => !!v || 'Item is required']"
              label="Address"
              required
              density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              label="Complement"
              density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="3" sm="6">
          <v-text-field
              label="Number"
              density="compact"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-form>
  </div>
</template>

<script lang="ts">
import { mask } from "vue-the-mask";
import {defineComponent} from "vue";
import Address from "~/Model/Address";

export default defineComponent ({
  name: "TheAddressAddList",
  directives: { mask },
  props: {
    address: {
      type: Array<Address>
    }
  }
})
</script>