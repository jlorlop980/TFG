//Control playlist
<script lang="ts">
import { apiService } from '../services/apiService'

export default {

  data() {
    return {
      apiService: new apiService(), //apiService
      token: "", //string
    }
  },

  methods: {
    increment() {
      
    }
  },


  mounted() {
    this.token=this.apiService.getToken();
    if(this.token){
      //this.getFavorites();
    }else{
      console.log("no hay token")
    }
  }
}
</script>

<template>
 <div>
    <div class="container">
      <h3 class="title-azul">Playlist</h3>
      <!-- Favorites -->
      <div class="playlist" v-if="token">
        <!-- <div class="favorite" v-for="favorite in favorites" :key="favorite.id">
          <img src="../assets/icons/removeLike.svg" @click="removeLike(favorite.id)">
          <p>{{favorite.songs.name}}</p>
          <img src="../assets/icons/playNegro.svg">
        </div> -->
      </div>
      <p class="white" v-if="!token">LogIn to see your PLaylist</p>
      <!-- <p @click="close()" class="white">asdas</p> -->
    </div> 
    <!-- <Transition>
      <div v-if="toast" class="toast">
        <div class="toastError" v-if="toastError">
          <p>Ha ocurrido un error</p>
        </div>
        <div class="toastSuccess" v-if="toastSuccess">
          <p>{{ toastMessage }}</p>
        </div>
      </div>
    </Transition> -->
  </div>
</template>

<style scoped src="../assets/styles/playlist.css">


</style>