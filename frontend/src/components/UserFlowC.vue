//Login-register page
<script lang="ts">
import { apiService } from "../services/apiService";
export default {
  data() {
    return {
      apiService: new apiService(), //apiService
      log: true, //boolen
      mail: "", //string
      password: "", //string
      username: "", //string
      validInput: false, //boolen
      toast: false, //boolen
      toastError: false, //boolen
      toastSuccess: false, //boolen
      toastMessage: "", //string
    };
  },

  methods: {
    changeView() {
      this.log = !this.log;
      this.mail = "";
      this.password = "";
      this.username = "";
    },
    close() {
      this.$emit("close");
    },
    login() {
      this.apiService
        .login(this.mail, this.password)
        .then((response) => {
          console.log(response);
          localStorage.setItem("token", response.data.token);
          this.$emit("logged");
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Logged in successfully";
          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
          }, 3000);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 401) {
            this.toast = true;
            this.toastError = true;
            this.toastMessage = "Wrong password or mail";
            setTimeout(() => {
              this.toast = false;
              this.toastError = false;
              this.toastMessage = "";
            }, 3000);
          }
        });
    },
    register() {
      this.apiService
        .register(this.username, this.mail, this.password)
        .then((response) => {
          console.log(response);
          localStorage.setItem("token", response.data.token);
          this.$emit("logged");
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Registered successfully";
          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
          }, 3000);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status >= 400) {
            this.toast = true;
            this.toastError = true;
            this.toastMessage = "Invalid Credentials";
            setTimeout(() => {
              this.toast = false;
              this.toastError = false;
              this.toastMessage = "";
            }, 3000);
          }
        });
      this.$emit("register");
    },
  },

  mounted() {
    console.log("mounted");
  },
};
</script>

<template>
  <div>
    <div class="container" v-if="log">
      <div class="toolbar">
        <h3 class="title">Login</h3>
        <img
          src="../assets/icons/crossBlanco.svg"
          @click="close()"
          class="cruz"
        />
      </div>
      <!-- Inputs -->
      <div class="central">
        <form>
          <input type="text" placeholder="mail" v-model="mail" />
          <input type="password" placeholder="password" v-model="password" />
        </form>

        <p class="button" @click="login">send</p>
        <p @click="changeView()" class="change">registro</p>
      </div>
    </div>

    <div class="container" v-if="!log">
      <div class="toolbar">
        <h3 class="title">Registro</h3>
        <img
          src="../assets/icons/crossBlanco.svg"
          @click="close()"
          class="cruz"
        />
      </div>
      <!-- inputs -->
      <div>
        <form>
          <input type="text" placeholder="nick" v-model="mail" />
          <input type="text" placeholder="mail" v-model="username" />
          <input type="password" placeholder="password" v-model="password" />
        </form>
      </div>
      <p class="button" @click="register">send</p>
      <p @click="changeView()" class="change">login</p>
    </div>

    <Transition>
      <div v-if="toast" class="toast">
        <div class="toastError" v-if="toastError">
          <p>{{ toastMessage }}</p>
        </div>
        <div class="toastSuccess" v-if="toastSuccess">
          <p>{{ toastMessage }}</p>
        </div>
      </div>
    </Transition>
  </div>
</template>

<style scoped src="../assets/styles/userflow.css">
/* @import "../assets/styles/userflow.css"; */
</style>
