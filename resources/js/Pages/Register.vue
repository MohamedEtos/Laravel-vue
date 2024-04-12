<script setup>

import { Axios } from "axios";
import { ref } from "vue";

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');

const confirmPass = () => {
    if(password.value !== password_confirmation.value){
        alert('passowrd not match');;
    }
};


const Register = () => {

    if(name.value === '' ||email.value === ''|| password.value === '' || password_confirmation === ''){
        alert('plase fill all fields');
    }else{

        axios.post('/api/register',{
            name:name.value,
            email:email.value,
            password:password.value,
            password_confirmation:password_confirmation.value
        }).then((res) => {
            localStorage.setItem('access_token',res.data.access_token)
            // localStorage.setItem('user',JSON.stringify(res.data.user))
            window.location.href = '/admin'
        }).catch((err)=>{
            console.log(err)
        })
    }



};


</script>
<template>
            <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" v-model="name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" v-model="password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" v-change="confirmPass" v-model="password_confirmation" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <a @click="Register()" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a>

                                <hr>

                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link class="small" to="forgetPassword">Forgot Password?</router-link>
                            </div>
                            <div class="text-center">
                                <router-link
                                class="small"
                                to="Login">
                                Already have an account? Login!
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
