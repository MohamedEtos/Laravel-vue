<script setup>
import { ref } from "vue";

const email = ref("");
const errors = ref('')
const password = ref("");

const login = () => {
  if (email.value === "" || password.value === "") {
    alert("plase fill all fields");
  } else {
    axios
      .post("/api/login", {
        email: email.value,
        password: password.value,
      })
      .then((res) => {
        if (res.data.status === 200) {
          localStorage.setItem("access_token", res.data.access_token);
          window.location.href = "/admin";
        }
      })
      .catch((err) => {
          // errors.value = err.response.data.message
          errors.value = 'the email or password wrong'
      });
  }
};
</script>
<template>
  <div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <form class="user" method="post">
                  <div class="form-group">
                    <input
                      type="email"
                      v-model="email"
                      class="form-control form-control-user"
                      id="exampleInputEmail"
                      aria-describedby="emailHelp"
                      placeholder="Enter Email Address..."
                    />
                  </div>
                  <div class="form-group">
                    <input
                      type="password"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      v-model="password"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck"
                      />
                        <div class="text-danger" v-if="errors">{{ errors }}</div>

                        <label class="custom-control-label" for="customCheck"
                        >Remember Me</label
                      >
                    </div>
                  </div>
                  <a @click="login()" class="btn btn-primary btn-user btn-block">
                    Login
                  </a>
                  <hr />
                </form>
                <hr />
                <div class="text-center">
                  <router-link class="small" to="forgetPassword">Forgot Password?</router-link>
                </div>
                <div class="text-center">
                  <router-link class="small" to="register"
                    >Create an Account!</router-link
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
