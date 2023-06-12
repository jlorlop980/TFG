//favorites of the user
<script lang="ts">
import { apiService } from '../services/apiService'
import { Favorite } from '../models/AllModels'

export default {

  data() {
    return {
      apiService: new apiService(), //apiService
      favorites: [] as Favorite[], //Favorites
      token: "", //string
      toast: false, //boolean
      toastError: false, //string
      toastSuccess: false, //string
      toastMessage: "", //string
      count: 0
    }
  },

  methods: {
    getFavorites(){
      this.apiService.getAllFavorites(this.token).then((response) => {
        console.log(response);
        this.favorites = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    close(){
      this.$emit('close');
    },
    removeLike(id: number){
      this.apiService.deleteFavorite(id).then((response) => {
        this.toast = true;
        this.toastSuccess = true;
        this.toastMessage = "Favorite removed successfully";
        setTimeout(() => {
          this.toast = false;
          this.toastSuccess = false;
          this.toastMessage = "";
        }, 3000);
        console.log(response);
        this.getFavorites();
      }).catch((error) => {
        console.log(error);
      });
    }
  },

  mounted() {
    this.token=this.apiService.getToken();
    if(this.token){
      this.getFavorites();
    }else{
      console.log("no hay token")
    }
  }
}
</script>

<template>
  <div>
    <div class="container">
      <h3 class="title">Favorites</h3>
      <!-- Favorites -->
      <div class="favorites" v-if="token">
        <div class="favorite" v-for="favorite in favorites" :key="favorite.id">
          <img src="../assets/icons/removeLike.svg" @click="removeLike(favorite.id)">
          <p>{{favorite.songs.name}}</p>
          <img src="../assets/icons/playNegro.svg">
        </div>
      </div>
      <p class="white" v-if="!token">LogIn to see your Favorites</p>
      <p @click="close()" class="white">asdas</p>
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

<style scoped src="../assets/styles/favorites.css">

</style>