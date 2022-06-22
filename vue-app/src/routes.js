import HomePage from './components/HomePage'
import LoginPage from './components/LoginPage'
import RegisterPage from './components/RegisterPage'
import NotFound from './components/NotFound.vue'

/** @type {import('vue-router').RouterOptions['routes']} */
export let routes = [
    { path: '/', component: HomePage, meta: { title: 'Home', requiresAuth: true } },
    { path: '/login', component: LoginPage, meta: { title: 'Login' } },
    { path: '/register', component: RegisterPage, meta: { title: 'Register' } },
    { path: '/:path(.*)', component: NotFound },
]

