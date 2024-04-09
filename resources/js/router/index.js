import { createRouter,createWebHistory } from "vue-router";
const router = createRouter({
    history:createWebHistory(),
    routes : [
        {
            path:'/home',
            name:'Master',
            component:() => import ('../Layouts/Master.vue')
        },
        {
            path:'/admin',
            name:'dashboard',
            component:() => import ('../Pages/Admin.vue')
        },
        {
            path:'/login',
            name:'login',
            component:() => import ('../Pages/Login.vue')
        },
        {
            path:'/register',
            name:'register',
            component:() => import ('../Pages/register.vue')
        }
    ]
})

export default router
