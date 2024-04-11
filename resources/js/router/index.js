import { createRouter,createWebHistory } from "vue-router";
import {isUserLoggedIn} from "./utils";
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

// GOOD
// router.beforeEach((to, from, next) => {
//     if (to.name !== 'login' && !isUserLoggedIn()) next({ name: 'Login' })
//     else next()
// })


router.beforeEach((to,from,next)=>{

    if ( to.name === 'register' && !isUserLoggedIn())
    {
        next()
    }
    else if(to.name !== 'login' && !isUserLoggedIn())
    {
        next({name:'login'})
    }
    else if ((to.name === 'login' || to.name === 'register') && isUserLoggedIn())
    {
        next({name:'admin'})
    }
    else{
        next()
    }
})
export default router
