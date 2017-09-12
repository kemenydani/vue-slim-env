import Vue from 'vue'

import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'

import Vuex from 'vuex'

import App from './App.vue'

import { routes } from './routes'

Vue.use(VueAxios, axios)
Vue.use(VueRouter)
Vue.use(Vuex)

const router = new VueRouter({
    routes: routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && false/* check if authenticated here */ ) {
        next({ name: 'login' })
    } else {
        next()
    }
})

new Vue({
    el: '#app',
    render: h => h(App),
    router: router
})