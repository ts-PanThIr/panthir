<script setup>
import { useAuthStore } from '~/stores';

async function onSubmit(values) {
    const authStore = useAuthStore();
    const { username, password } = values;
    await authStore.login(username, password);
}
</script>

<template>
  <v-container fluid>
      <v-card class="w-75 mx-auto" elevation="15">
        <v-card-title class="text-center">
          <h1 class="pa-3">Welcome back!</h1>
        </v-card-title>
        <v-card-text>
          <v-form
              v-model="form"
              @submit.prevent="onSubmit"
          >
            <v-text-field
                v-model="email"
                :rules="emailRules"
                class="mb-2"
                clearable
                label="Email"
            ></v-text-field>

            <v-text-field
                v-model="password"
                :rules="passwordRules"
                type="password"
                clearable
                label="Password"
                placeholder="Enter your password"
            ></v-text-field>

            <br>

            <v-btn
                :disabled="!form"
                block
                color="success"
                size="large"
                type="submit"
                variant="elevated"
            >
              Sign In
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
  </v-container>
</template>

<script>
export default {
  data () {
    return {
      valid: false,
      form: false,
      password: '',
      passwordRules: [
        (v) => !!v || 'Password is required',
      ],
      email: '',
      emailRules: [
        (v) => !!v || 'E-mail is required',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ],
    }
  }
}
</script>
