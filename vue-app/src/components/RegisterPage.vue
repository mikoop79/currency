<template>
  <div class="p-4 text-center text-gray-400 border-gray-100 rounded-lg  h-96 w-500 login">
    <div class="form">
      <h1>Register</h1>
      <div class="form-group">
        <label for="name">Name</label>
        <input
          v-model="user.name"
          type="text"
        >
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input
          v-model="user.email"
          type="text"
        >
      </div>
      <div class="form-group">
        <label for="password">Password</label>

        <input
          v-model="user.password"
          type="password"
        >
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm</label>
        <input
          v-model="user.password_confirmation"
          type="password"
        >
      </div>
      <div class="form-group">
        <div class="label" />
        <button
          class="submit cursor-pointer rounded-none px-10 bg-gray-400 text-white"
          value=""
          @click="register()"
        >
          Register
        </button>
        <div class="label" />
        <div class="message">
          {{ message }}
        </div>

        <div class="message text-xs text-red-600">
          <ul>
            <li
              v-for="(error) in errors"
              :key="error.id"
              class="text-left"
            >
              {{ error }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";


export default {
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        message: [],
      },
      errors: []
    };
  },

  methods: {
    register() {
      axios.post('/api/auth/register', this.user)
          .then(() => {
            this.$router.push('/login');
          })
          .catch((error) => {
            console.log('errors');
            console.log(error.response.data.errors);
            this.errors = error.response.data.errors;
          });
    }
  }
}
</script>