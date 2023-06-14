// nav with login, favorites, playlist and search
<script lang="ts">
import { apiService } from "../services/apiService";

interface Props {
  user: string;
}
export default {
  props: {
    user: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      apiService: new apiService(),
      isOpen: false,
      dialogText: "Are you sure you want to LogOut?",
      toast: false,
      toastError: false,
      toastSuccess: false,
      toastMessage: "",
    };
  },

  methods: {
    clickedPlaylist() {
      this.$emit("plClicked");
    },
    clickedFavorites() {
      this.$emit("favClicked");
    },
    clickedSearch() {
      this.$emit("shClicked");
    },
    clickedAccount() {
      if (this.user == "Login") {
        this.$emit("accClicked");
      } else {
        this.isOpen = !this.isOpen;
      }
    },
    clickedTitle() {
      this.$emit("tClicked");
      console.log(5);
    },
    handleClose() {
      this.isOpen = false;
    },
    cancel() {
      this.isOpen = false;
      console.log("cancelado");
    },
    accept() {
      this.apiService.logOut().then((response) => {
        this.toast = true;
        this.toastSuccess = true;
        this.toastMessage = "Logged out successfully";
        setTimeout(() => {
          this.toast = false;
          this.toastSuccess = false;
          this.toastMessage = "";
        }, 3000);
        console.log(response);
        this.$emit("logout");
      });
      this.isOpen = false;
    },
  },
};
</script>

<template>
  <div class="navbar">
    <p class="element" v-on:click="clickedPlaylist">Playlist</p>
    <p class="element" v-on:click="clickedFavorites">Favorites</p>
    <p class="element titleNavbar" v-on:click="clickedTitle">Lofi Player</p>
    <p class="element" v-on:click="clickedAccount">{{ user }}</p>
    <p class="element" v-on:click="clickedSearch">Search</p>
  </div>

  <div v-if="isOpen" class="dialog-backdrop">
    <dialog :open="isOpen" @close="handleClose" class="custom-dialog">
      <p class="f-Marck f-15">{{ dialogText }}</p>
      <div class="dialog-butons">
        <button class="boton-cancelar" @click="cancel">No</button>
        <button class="boton" @click="accept">Yes</button>
      </div>
    </dialog>
  </div>
  <div v-if="toast" class="toast">
    <div class="toastError" v-if="toastError">
      <p>{{ toastMessage }}</p>
    </div>
    <div class="toastSuccess" v-if="toastSuccess">
      <p>{{ toastMessage }}</p>
    </div>
  </div>
</template>

<style scoped src="../assets/styles/navbar.css"></style>
