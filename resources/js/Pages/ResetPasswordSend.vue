<script setup>
import {ref} from 'vue';

const errors = ref('')
const password = ref('')
const password_confirmation = ref('')

const comfirmpass = () => {
    if(password.value !== password_confirmation.value){
        alert('password not match')
    }
}

const Resetpassword = () =>{
    if(password.value === '' || password_confirmation.value === ''){
        alert('plase fill all failds')
    }else {
        axios.post('/api/resetPass',{
            password: password.value,
            password_confirmation: password_confirmation.value
        }).then((res)=>{
            alert(res.data.message)
            window.location.href = '/admin'
        }).catch((err)=>{
            console.log(err)
        })
    }
}
</script>


<template>
    <div class="row justify-content-center mt-5">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Reset Password !</h1>
                                </div>
                                <form class="user" method="post">

                                    <div class="form-group">
                                        <input
                                            type="password"
                                            class="form-control form-control-user"
                                            v-model="password"
                                            placeholder="Password"
                                        />
                                        <label v-if="errors.length>0" class="text-danger pl-3">{{errors}}</label>
                                    </div>
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            class="form-control form-control-user"
                                            v-model="password_confirmation"
                                            @change="comfirmpass"
                                            placeholder="Repeat Password"
                                        />
                                    </div>

                                    <a @click="Resetpassword()" class="btn btn-primary btn-user btn-block">
                                        Reset password
                                    </a>
                                    <hr />
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
