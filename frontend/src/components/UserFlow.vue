//Login-register page
<script lang="ts">

export default {

  data() {
    return {
      count: 0,
      login: false
    }
  },


  methods: {
    changeView() {
      this.login=!this.login;
    },
    close(){
      this.$emit('close');
    }
  },

  mounted() {
    console.log(`The initial count is ${this.count}.`)
  }
}
</script>


<template>
  <div class="container">
    <h3 class="title" v-if="login">Login</h3>
    <h3 class="title" v-else>Register</h3>
    <svg class="cruz" @click="close"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
    <!-- Botones para cambiar entre login y registro -->
    <p v-if="login" @click="changeView()" class="boton">registro</p>
    <p v-else @click="changeView()">login</p>
  </div>
  

</template>


<style scoped src="../assets/styles/userflow.css">
  /* @import "../assets/styles/userflow.css"; */
</style>