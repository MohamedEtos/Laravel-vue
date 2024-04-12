<script setup>
import {ref} from "vue";

const email = ref('')
const loading = ref(false)
const send = ref(false)

const ResetPassword =()=>{
    if(email.value === ''){
        alert('plase fill email ')
    }else {
        loading.value = true
        axios.post('/api/resetPassword',{
            email: email.value
        }).then((res)=>{
            if (res.data.status === 200) {
                loading.value = false
                send.value = true
                alert(res.data.message)
            }else {
                alert(res.data.message);
            }
        }).catch((err)=>{
            console.log(err)
        })
    }
}



</script>
<template>
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p v-if="send" class="mb-4">We get it, stuff happens. Just enter your email address below
                                        and we'll send you a link to reset your password!</p>
                                </div>
                                <form class="user" method="post" >
                                    <div class="form-group" v-if="loading">
                                        <input type="email"  disabled class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group" v-if="!loading">
                                        <input type="email" v-model="email" class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address...">
                                    </div>
                                    <a v-if="!loading" @click="ResetPassword()" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </a>
                                    <a v-if="loading"  class="btn btn-primary btn-user btn-block">
                                        waiting ....
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <router-link class="small" to="register">Create an Account!</router-link>
                                </div>
                                <div class="text-center">
                                    <router-link class="small" to="loginl">Already have an account? Login!</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
