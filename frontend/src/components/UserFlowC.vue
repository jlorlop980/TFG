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
      isValid: false, //boolen,
      isPasswordValid: false, //boolen
      isTooltipVisible: false,
    };
  },

  methods: {
    changeView() {
      this.log = !this.log;
      this.mail = "";
      this.password = "";
      this.username = "";
      this.isValid = false;
      this.isPasswordValid = false;
    },
    hideTooltip() {
      this.isTooltipVisible = false;
    },
    showTooltip() {
      this.isTooltipVisible = true;
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
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Logged in successfully";

          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
            this.$emit("logged");
          }, 2500);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 401) {
            this.toast = true;
            this.toastError = true;
            this.toastMessage = error.response.data.message;
            setTimeout(() => {
              this.toast = false;
              this.toastError = false;
              this.toastMessage = "";
            }, 3000);
          }
        });
    },
    validateEmail() {
      // Expresión regular para validar el correo electrónico
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      this.isValid = emailRegex.test(this.mail);
    },
    validatePassword() {
      const passwordRegex = /^\d{8,}$/;
      this.isPasswordValid = passwordRegex.test(this.password);
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
  <!-- login -->
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
      <div class="central2">
        <div class="formulario">
          <div class="input-group">
            <span
              class="input-group-addon"
              :class="!isValid ? 'invalid' : 'valid'"
            >
              <img class="icono" src="../assets/icons/mail.svg" />
            </span>
            <input
              type="text"
              placeholder="Mail"
              class="f-Marck"
              v-model="mail"
              :class="!isValid ? 'invalid' : 'valid'"
              @input="validateEmail"
            />
          </div>

          <div class="input-group tooltip-container">
            <span
              class="input-group-addon"
              :class="!isPasswordValid ? 'invalid' : 'valid'"
              @mouseenter="showTooltip"
              @mouseleave="hideTooltip"
            >
              <img class="icono" src="../assets/icons/key.svg" />
            </span>
            <span class="tooltip" v-show="isTooltipVisible"
              >At least 8 characters with 1 number</span
            >

            <input
              type="password"
              placeholder="Password"
              class="f-Marck"
              v-model="password"
              :class="!isPasswordValid ? 'invalid' : 'valid'"
              @input="validatePassword"
            />
          </div>

          <!-- 
          <input type="text" placeholder="nick" v-model="mail" />
          <input type="text" placeholder="mail" v-model="username" />
          <input type="password" placeholder="password" v-model="password" /> -->
        </div>

        <button
          class="boton f-Marck separacion mt-2"
          :disabled="!isValid || !isPasswordValid"
          @click="login"
        >
          Send
        </button>

        <p @click="changeView()" class="change">Register</p>
      </div>
    </div>

    <!-- register -->
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
      <div class="formulario">
        <div class="input-group">
          <span
            class="input-group-addon"
            :class="!isValid ? 'invalid' : 'valid'"
          >
            <img class="icono" src="../assets/icons/mail.svg" />
          </span>
          <input
            type="text"
            placeholder="Mail"
            class="f-Marck"
            v-model="mail"
            :class="!isValid ? 'invalid' : 'valid'"
            @input="validateEmail"
          />
        </div>
        <div class="input-group">
          <span
            class="input-group-addon"
            :class="!username ? 'invalid' : 'valid'"
          >
            <img class="icono" src="../assets/icons/user.svg" />
          </span>
          <input
            type="text"
            placeholder="Username"
            class="f-Marck"
            v-model="username"
            :class="!username ? 'invalid' : 'valid'"
          />
        </div>
        <div class="input-group tooltip-container">
          <span
            class="input-group-addon"
            :class="!isValid ? 'invalid' : 'valid'"
            @mouseenter="showTooltip"
            @mouseleave="hideTooltip"
          >
            <img class="icono" src="../assets/icons/key.svg" />
          </span>
          <span class="tooltip" v-show="isTooltipVisible"
            >At least 8 characters and 1 number</span
          >

          <input
            type="password"
            placeholder="Password"
            class="f-Marck"
            v-model="password"
            :class="!isPasswordValid ? 'invalid' : 'valid'"
            @input="validatePassword"
          />
        </div>
      </div>
      <!-- <p class="button" @click="register">send</p> -->
      <button
        class="boton f-Marck separacion mt-2"
        :disabled="!isValid || !isPasswordValid || !username"
        @click="register"
      >
        Send
      </button>
      <p @click="changeView()" class="change">Login</p>
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
