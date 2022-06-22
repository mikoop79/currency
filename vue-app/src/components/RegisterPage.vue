<template>
  <div class="p-4 text-center text-gray-400 border-gray-100 rounded-lg  h-96 w-500 login">
    <div class="form">
    <h1>Register</h1>
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" v-model="user.name">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" v-model="user.email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" v-model="user.password">
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirm</label>
      <input type="password" v-model="user.password_confirmation">
    </div>
      <div class="form-group">
        <div class="label"></div>
        <button class="submit cursor-pointer rounded-none px-10 bg-gray-400 text-white" @click="register()" value="" >Register</button>
        <div class="label"></div>
        <div class="message">{{ message }}</div>

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
      }
    };
  },

  methods: {
    register() {
      console.log(this.user);
      axios.post('/api/auth/register', this.user)
          .then(() => {
            this.$router.push('/login');
          })
          .catch((error) => {
            console.log(error.response.data.errors);
            this.message = error.response.data.errors;
          });
    }
  }
}
</script>