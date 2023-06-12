//Login-register page
<script lang="ts">
import { apiService } from '../services/apiService'
export default {

  data() {
    return {
      apiService: new apiService(), //apiService
      log: false, //boolen
      mail: '', //string
      password: '', //string
      username: '', //string
      validInput: false, //boolen
      toast: false, //boolen
      toastError: false, //boolen
      toastSuccess: false, //boolen
      toastMessage: "", //string
    }
  },


  methods: {
    changeView() {
      this.log=!this.log;
      this.mail='';
      this.password='';
      this.username='';
    },
    close(){
      this.$emit('close');
    },
    login(){
      this.apiService.login(this.mail,this.password).then((response) => {
        console.log(response);
        localStorage.setItem("token", response.data.token);
        this.$emit('logged');
      }).catch((error) => {
        console.log(error);
        if(error.response.status==401){
          alert("Wrong password or mail");
        }
      });
    },
    register(){
      this.apiService.register(this.username,this.mail,this.password,).then((response) => {
        console.log(response);
        localStorage.setItem("token", response.data.token);
        this.$emit('logged');
      }).catch((error) => {
        console.log(error);
        if(error.response.status>=400){
          alert("Wrong password or mail");
        }
      });
      this.$emit('register');
    }
  },

  mounted() {
    console.log("mounted")
  }
}
</script>


<template>
  <div>
  <div class="container" v-if="log">
    <h3 class="title">Login</h3>
    <svg class="cruz" @click="close"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
    <!-- Inputs -->
    <div>
      <form>
        <input type="text" placeholder="mail" v-model="mail">
        <input type="password" placeholder="password" v-model="password">
      </form>
    </div>
    <p class="button" @click="login">send</p>
    <p @click="changeView()" class="change">registro</p>
  </div>

  <div class="container" v-if="!log">
    <h3 class="title" >Register</h3>
    <svg class="cruz" @click="close"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
    <!-- inputs -->
    <div>
      <form>
        <input type="text" placeholder="nick" v-model="mail">
        <input type="text" placeholder="mail" v-model="username">
        <input type="password" placeholder="password" v-model="password">
      </form>
    </div>
    <p class="button" @click="register">send</p>
    <p @click="changeView()" class="change">login</p>
  </div>

  <Transition>
    <div v-if="toast" class="toast">
      <div class="toastError" v-if="toastError">
        <p>Ha ocurrido un error</p>
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