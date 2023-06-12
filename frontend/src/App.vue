<script setup lang="ts">
import { ref } from 'vue'
import HelloWorld from './components/HelloWorld.vue'
import NavBar from './components/NavBar.vue';
import UserFlow from './components/UserFlow.vue';
import { apiService } from './services/apiService'
import Favorites from './components/Favorites.vue';
import Playlist from './components/Playlist.vue';

const login= ref(false);
const fav= ref(false);
const playli= ref(false);
const user= ref("account");

function handleLogin(){
    login.value=!login.value;
    console.log(login.value);
}

function handleFav(){
  fav.value=!fav.value;
  console.log(fav.value);
}

function handlePlaylist(){
  playli.value=!playli.value;
  console.log(playli.value);
}

const api= new apiService();
api.getAllGenres().then((res:any) => {
  console.log(res.data);
});

function handleLog(){
  login.value=false;
  user.value="user";
  console.log("sesion iniciada")
}

</script>

<template>
    <div class="main">
        <NavBar @accClicked="handleLogin()" user="user" @favClicked="handleFav()" @plClicked="handlePlaylist()"></NavBar>
        <Transition >
          <UserFlow v-if="login" @close="() => login=false" @logged="handleLog"></UserFlow>
        </Transition>
        <Transition>
          <Favorites v-if="fav" @close="() => fav=false"></Favorites>
        </Transition>
        <Transition>
          <Playlist v-if="playli" @close="() => playli=false"></Playlist>
        </Transition>
    </div>
</template>

<style src="./assets/styles/main.css">

</style>
