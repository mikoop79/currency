import HomePage from './components/HomePage'
import LoginPage from './components/LoginPage'
import RegisterPage from './components/RegisterPage'
import NotFound from './components/NotFound.vue'

/** @type {import('vue-router').RouterOptions['routes']} */
export let routes = [
    { path: '/', component: HomePage, meta: { title: 'Reports', requiresAuth: true } },
    { path: '/login', component: LoginPage, meta: { title: 'Login to Start' } },
    { path: '/register', component: RegisterPage, meta: { title: 'Register an account' } },
    { path: '/:path(.*)', component: NotFound },
]

