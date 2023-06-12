//Control playlist
<script lang="ts">
import { apiService } from "../services/apiService";
import { Playlist } from "../models/AllModels";

interface Props {
  playlists: Playlist[];
}

export default {
  props: {
    playlists: {
      type: Array as () => Playlist[],
      required: true
    }
  },
  data() {
    return {
      apiService: new apiService(), //apiService
      token: "", //string
      toast: false, //boolean
      toastError: false, //string
      toastSuccess: false, //string
      toastMessage: "", //string
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    deletePLaylist(id: number) {
      this.apiService
        .deletePlaylist(id)
        .then((response) => {
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Playlist removed successfully";
          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
          }, 3000);
          console.log(response);
          this.$emit("removed");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deletePLaylistSong(idPlaylist: number, idSong: number) {
      this.apiService.deleteSongFromPlaylist(idPlaylist, idSong).then((response) => {
        this.toast = true;
        this.toastSuccess = true;
        this.toastMessage = "Song removed successfully from Playlist";
        setTimeout(() => {
          this.toast = false;
          this.toastSuccess = false;
          this.toastMessage = "";
        }, 3000);
        console.log(response);
        this.$emit("removed");
      }).catch((error) => {
        console.log(error);
      }
      );
    }
  },

  mounted() {
    this.token = this.apiService.getToken();
  },
};
</script>

<template>
  <div>
    <div class="container">
      <h3 class="title-azul">Playlist</h3>
      <!-- Playlists -->
      <div class="playlists" v-if="token">
        <div class="playlist" v-for="playlist in playlists" :key="playlist.id">
          <img
            src="../assets/icons/removeLike.svg"
            @click="deletePLaylist(playlist.id)"
          />
          <p>{{ playlist.name }}</p>
          <!-- Canciones -->
          <div class="canciones">
            <div class="cancion" v-for="song in playlist.songs" :key="song.id">
              <img
                src="../assets/icons/removeLike.svg"
                @click="deletePLaylistSong(playlist.id, song.id)"
              />
              <p>{{ song.name }} - {{ song.artist.name=="NoArtist" ? "Artista Desconocido" : song.artist.name }}</p>

            </div>
            <img src="../assets/icons/playNegro.svg" />
          </div>
        </div>
        <img src="../assets/icons/playNegro.svg" />
      </div>
    </div>
    <p class="white" v-if="!token">LogIn to see your PLaylist</p>
    <p @click="close()" class="white">asdas</p>

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

<style scoped src="../assets/styles/playlist.css"></style>
