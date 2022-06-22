import { createApp } from 'vue'
import './assets/output.css'
import App from './App.vue'
import { routes } from './routes.js'
import { createRouter, createWebHistory } from 'vue-router'
import Auth from './Auth'

let app = createApp(App);
let router = createRouter({
    history: createWebHistory(),
    routes: import.meta.hot ? [] : routes,
})
// check routes to be authorised
router.beforeEach(to => {
    if (to.matched.some(record => record.meta.requiresAuth) && !Auth.check()) return '/login'
})

if (import.meta.hot) {
    let removeRoutes = []

    for (let route of routes) {
        removeRoutes.push(router.addRoute(route))
    }

    import.meta.hot.accept('./routes.js', ({ routes }) => {
        for (let removeRoute of removeRoutes) removeRoute()
        removeRoutes = []
        for (let route of routes) {
            removeRoutes.push(router.addRoute(route))
        }
        router.replace('')
    })
}
// set the router to be used globally
window.routerInstance = router;
app.use(router)
app.mount('#app')
