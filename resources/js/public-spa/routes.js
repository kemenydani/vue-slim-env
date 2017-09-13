import userRoutes from './routes/user-routes'
import login from './components/login.vue'
import index from './components/index.vue'

const routes = [
    userRoutes,
    {
        path: '/login',
        name: 'login',
        component: login
    },
    {
        path: '/',
        component: index,
        meta: {
            requiresAuth : true
        }
    }
]

export { routes }