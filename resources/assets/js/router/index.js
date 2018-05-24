import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Show from '../views/Show.vue'
import List from '../views/List.vue'
import Layout from '../components/Layout.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '',
        component: Layout,
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
            },
            {
                path: 'users',
                name: 'users',
                component: List,
            },
            {
                path: 'users/:id',
                name: 'users.show',
                component: Show,
            }
        ]
    }
]

export default new VueRouter({
    routes,
    linkExactActiveClass: 'active'
})
