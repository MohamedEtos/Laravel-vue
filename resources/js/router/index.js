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
        }
    ]
})

export default router
