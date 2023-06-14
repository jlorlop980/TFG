//favorites of the user
<script lang="ts">
import { apiService } from "../services/apiService";
import { Favorite } from "../models/AllModels";

interface Props {
  favorites: Favorite[];
}

export default {
  props: {
    favorites: {
      type: Array as () => Favorite[],
      required: true,
    },
  },
  data() {
    return {
      apiService: new apiService(), //apiService
      token: "", //string
      toast: false, //boolean
      toastError: false, //string
      toastSuccess: false, //string
      toastMessage: "", //string
      isOpen: false,
      dialogText: "Are you sure you want to remove this Fav?",
      possRemFav: 0,//number
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    openDialog(id:number) {
      this.isOpen = true;
      this.possRemFav = id;
    },
    removeLike(id: number) {
      this.apiService
        .deleteFavorite(id)
        .then((response) => {
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Favorite removed successfully";
          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
          }, 3000);
          console.log(response);
          //hacer emit "removed"
          this.$emit("removed");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    playClicked(id:number) {
      this.$emit("playClick",id);
    },
    handleClose() {
      this.isOpen = false;
    },
    cancel() {
      this.isOpen = false;
      console.log("cancelado");
    },
    accept() {
     this.removeLike(this.possRemFav);
      this.isOpen = false;
    },
  },

  mounted() {
    this.token = this.apiService.getToken();
    console.log(this.favorites);
  },
};
</script>

<template>
  <div>
    <div class="container">
      <div class="toolbar">
        <h3 class="title">Favorites</h3>
        <img src="../assets/icons/crossBlanco.svg" @click="close()" class="cruz">
      </div>
      <!-- Favorites -->
      <div class="favorites" v-if="token">
        <div class="favorite" v-for="favorite in favorites" :key="favorite.id">
          <img
            src="../assets/icons/removeLike.svg"
            @click="openDialog(favorite.id)"
          />
          <p class="f-Cat">{{ favorite.songs.name }}</p>
          <img src="../assets/icons/playNegro.svg" @click="playClicked(favorite.id_song)"/>
        </div>
      </div>
      <p class="white" v-if="!token">LogIn to see your Favorites</p>
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
    <div v-if="isOpen" class="dialog-backdrop">
    <dialog :open="isOpen" @close="handleClose" class="custom-dialog">
      <p class="f-Marck f-15">{{ dialogText }}</p>
      <div class="dialog-butons">
        <button class="boton-cancelar" @click="cancel">Cancelar</button>
        <button class="boton" @click="accept">Aceptar</button>
      </div>
    </dialog>
  </div>
  </div>
</template>

<style scoped src="../assets/styles/favorites.css"></style>
