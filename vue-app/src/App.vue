<template>
  <div>
    <nav class="bg-gray-800">
      <div class="max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img
                class="w-8 h-8"
                src="/images/logo.png"
                alt="logo"
              >
            </div>
            <div class="hidden md:block">
              <div class="flex items-baseline ml-10">
                <router-link
                  v-for="(link, i) in links"
                  :key="i"
                  v-slot="{ navigate, href, isExactActive }"
                  :to="link.to"
                  custom
                >
                  <a
                    :href="href"
                    class="px-3 py-2 text-sm font-medium rounded-md"
                    :class="[
                      isExactActive
                        ? 'text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700'
                        : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700',
                      i > 0 && 'ml-4',
                    ]"
                    @click="navigate"
                  >{{ link.text }}</a>
                </router-link>
                <a
                  v-if="auth.check()"
                  class="px-3 py-2 text-sm font-medium cursor-pointer rounded-md text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700"
                  @click="logout().then(() => (showMenu = false))"
                >
                  Logout
                </a>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="flex items-center ml-4 md:ml-6">
              <!-- Profile dropdown -->
              <div class="relative ml-3" />
            </div>
          </div>

          <div class="flex -mr-2 md:hidden">
            <!-- Mobile menu button -->
            <button
              class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md  hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white"
              @click="showMenu = !showMenu"
            >
              <!-- Menu open: "hidden", Menu closed: "block" -->
              <svg
                class="block w-6 h-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
              <!-- Menu open: "block", Menu closed: "hidden" -->
              <svg
                class="hidden w-6 h-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!--
      Mobile menu, toggle classes based on menu state.

      Open: "block", closed: "hidden"
    -->
      <div
        class="md:hidden"
        :class="showMenu ? 'block' : 'hidden'"
      >
        <div class="px-2 pt-2 pb-3 sm:px-3">
          <router-link
            v-for="(link, i) in links"
            :key="i"
            v-slot="{ navigate, href, isExactActive }"
            :to="link.to"
            custom
          >
            <a
              :href="href"
              class="block px-3 py-2 text-base font-medium rounded-md"
              :class="[
                isExactActive
                  ? 'text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700'
                  : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700',
                i > 0 && 'mt-1',
              ]"
              @click="navigate().then(() => (showMenu = false))"
            >{{ link.text }}</a>
          </router-link>
          <!--          <a v-if="auth.check()" class="block px-3 py-2 text-base font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700"-->

          <a
            v-if="auth.check()"
            class="px-3 py-2 text-sm font-medium rounded-md text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700"
            @click="logout().then(() => (showMenu = false))"
          >
            Logout
          </a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5" />
        </div>
      </div>
    </nav>

    <header
      v-if="$route.meta.title"
      class="bg-white shadow"
    >
      <div class="max-w-screen-xl px-4 py-6 mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          {{ $route.meta.title }}
        </h1>
      </div>
    </header>

    <div class="max-w-screen-xl py-6 mx-auto sm:px-6 lg:px-8">
      <router-view />
    </div>
    <div>{{ message }}</div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import Auth from './Auth'
import axios from "axios";

export default defineComponent({

  data: () => ({
    auth: Auth,
    message:"",
    showMenu: false,
    showProfileMenu: false,
    links: [
      { text: 'Home', to: '/' },
      { text: 'Login', to: '/login' },
      { text: 'Register', to: '/register' },
    ],
  }),
  methods : {
    logout(){
      Auth.logout();
      axios.post('/api/auth/logout')
          .then(() => {
            this.showMenu = false;
            let that = this;
            setTimeout(function(){
              that.$router.push('/login');
            }, 1000);
          })
          .catch((error) => {
            this.message = error.message;
          });
    }
  }
})

</script>
