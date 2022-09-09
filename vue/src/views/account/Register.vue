<template>
  <v-container fluid>
    <v-card
        class="mx-auto mt-16"
        elevation="15"
        max-width="400"
    >
      <v-card-title class="text-center">
        <h3 class="pa-3">User Registration</h3>
      </v-card-title>
      <v-card-text>
        <v-text-field
            v-model="first"
            color="primary"
            label="First name"
            variant="underlined"
        ></v-text-field>

        <v-text-field
            v-model="last"
            color="primary"
            label="Last name"
            variant="underlined"
        ></v-text-field>

        <v-text-field
            v-model="email"
            :rules="emailRules"
            color="primary"
            label="Email"
            variant="underlined"
        ></v-text-field>

        <v-text-field
            v-model="password"
            :rules="passwordRules"
            color="primary"
            label="Password"
            placeholder="Enter your password"
            variant="underlined"
        ></v-text-field>

        <v-checkbox
            v-model="terms"
            color="secondary"
            label="I agree to site terms and conditions"
        ></v-checkbox>
      </v-card-text>

      <v-divider></v-divider>

      <router-link class="text-decoration-none d-block pa-3 text-center" :to="{ name: 'login'}">Sign in</router-link>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn
          block
          color="success"
          variant="elevated"
        >
          Complete Registration
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    first: null,
    last: null,
    email: null,
    password: null,
    terms: false,
    passwordRules: [
      (v) => !!v || 'Password is required',
    ],
    emailRules: [
      (v) => !!v || 'E-mail is required',
      (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
    ],
    form: false
  }),
}
</script>