/*
import Index   from '../components/user/index.vue'
import Factory from '../components/user/factory.vue'
import View    from '../components/user/view.vue'
import List    from '../components/user/list.vue'
*/

const Index = resolve => {
    require.ensure(['../components/user/index.vue'], () => {
        resolve(require('../components/user/index.vue'));
    })
}
const Factory = resolve => {
    require.ensure(['../components/user/factory.vue'], () => {
        resolve(require('../components/user/factory.vue'));
    })
}
const View = resolve => {
    require.ensure(['../components/user/view.vue'], () => {
        resolve(require('../components/user/view.vue'));
    })
}
const List = resolve => {
    require.ensure(['../components/user/list.vue'], () => {
        resolve(require('../components/user/list.vue'));
    })
}

export default
{
    path: '/user',
    component: Index,
    children: [
        {
            path: '/',
            component: List,
            name: 'user.list'
        },
        {
            path: 'create',
            component: Factory,
            name: 'user.create',
            meta: {
                requiresAuth : true
            }
        },
        {
            path: 'modify/:id',
            component: Factory,
            name: 'user.modify',
            meta: {
                requiresAuth: true
            }
        },
        {
            path: 'view/:id',
            component: View,
            name: 'user.view'
        }
    ]
}