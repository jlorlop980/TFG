<script setup lang="ts">
import { ref } from 'vue'
import HelloWorld from './components/HelloWorld.vue'
import NavBar from './components/NavBar.vue';
import UserFlow from './components/UserFlow.vue';
import { apiService } from './services/apiService'

const login = ref(false);
function handleLogin(){
    login.value=!login.value;
    console.log(login.value);
}
const api= new apiService();
api.getAllGenres().then((res:any) => {
  console.log(res.data);
});

</script>

<template>
    <div class="main">
        <NavBar @accClicked="handleLogin()"></NavBar>
        <Transition>
        <UserFlow v-if="login" @close="() => login=false"></UserFlow>
        </Transition>
    </div>
</template>

<style src="./assets/styles/main.css">

</style>
