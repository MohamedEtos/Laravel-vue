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
        },
        {
            path:'/forgetPassword',
            name:'forgetPassword',
            component:() => import ('../Pages/forgetPassword.vue')
        },
        {
            path:'/:pathMatch(.*)*',
            component:() => import ('../Pages/errors/404.vue')
        }
    ]
})





router.beforeEach((to,from,next)=>{

    if ( (to.name === 'register' || to.name === 'forgetPassword') && !isUserLoggedIn())
    {
        next()
    }

    else if(to.name !== 'login' && !isUserLoggedIn())
    {
        next({name:'login'})
    }
    else if ((to.name === 'login' || to.name === 'register') && isUserLoggedIn())
    {
        next({path:'/admin'})
    }
    else{
        next()
    }
})
export default router
