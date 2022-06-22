<template>

  <main>
    <div class="px-4 py-6 sm:px-0">

      <div class="p-4 text-center text-gray-400 border-4 border-gray-200 border-dashed rounded-lg  h-96"
           v-if="!this.showLogin">
        You are already logged in..
        <router-link
            to="/"
            class="text-indigo-600 underline hover:text-indigo-500"
        >Generate Report
        </router-link
        >

      </div>
      <div v-else
           class="p-4 text-center text-gray-400 border-gray-100 rounded-lg  h-96 w-500 login">
        <div class="form">
          <h1>Login</h1>

          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" v-model="user.email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" v-model="user.password">
          </div>
          <div class="form-group">
            <div class="label"></div>
            <button class="submit cursor-pointer rounded-none px-10 bg-gray-400 text-white" @click="login"
                    >Submit</button>
            <div class="label"></div>
            <div class="message">{{ message }}</div>
          </div>
          <div class="form-group">
            <div class="label"></div>
            <div class="message text-xs">No login? <a href="/register">Register</a></div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div>

  </div>
</template>

<script>
import Auth from '../Auth.js';
import axios from "axios";

export default {
  data() {
    return {
      message: '',
      user: {
        email: '',
        password: '',
      }
    };
  },

  computed: {
    showLogin() {
      const authenticated = Auth.check()
      return !authenticated
    }
  },

  methods: {
    login() {
      axios.post('/api/auth/login', this.user)
          .then(({data}) => {
             Auth.setUser(data.access_token, data.user);
             this.$router.push('/');
          })
          .catch((error) => {
            this.message = error.response.data.error;
          });
    }
  }
}
</script>