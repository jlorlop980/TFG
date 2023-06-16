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
      showSongs: {} as { [key: number]: boolean },
      dialogText: "",
      possRemSong: 0, //number
      possRemPLay: 0, //number
      isOpenCreating: false, //boolean
      newPlaylistName: "", //string
      isValid: false, //boolean
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    accept() {
      //eliminar lo que sea
      if (this.possRemSong != 0) {
        this.deletePlaylistSong(this.possRemPLay, this.possRemSong);
        this.possRemSong = 0;
        this.possRemPLay = 0;
      } else {
        this.deletePlaylist(this.possRemPLay);
        this.possRemPLay = 0;
      }
      this.isOpen = false;
    },
    toggleSongs(playlistId: number) {
      this.showSongs[playlistId] = !this.showSongs[playlistId];
    },
    cancel() {
      this.isOpen = false;
      this.possRemPLay = 0;
      this.possRemSong = 0;
      console.log("cancelado");
    },

    deletePlaylist(id: number) {
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
          this.toast = true;
          this.toastError = true;
          this.toastMessage = "Error removing Playlist";
          setTimeout(() => {
            this.toast = false;
            this.toastError = false;
            this.toastMessage = "";
          }, 3000);
        });
    },
    openDialog(idPL: number, idSong: number) {
      if (idSong == 0) {
        this.dialogText = "Are you sure you want to remove this Playlist?";
      } else {
        this.dialogText = "Are you sure you want to remove this Song?";
      }
      this.isOpen = true;
      this.possRemPLay = idPL;
      this.possRemSong = idSong;
    },
    handleClose() {
      this.isOpen = false;
      this.possRemPLay = 0;
      this.possRemSong = 0;
    },
    playSong(playlistId: number, songId: number) {
      console.log("pulsado");
      this.$emit("play", playlistId, songId);
    },
    deletePlaylistSong(idPlaylist: number, idSong: number) {
      this.apiService
        .deleteSongFromPlaylist(idPlaylist, idSong)
        .then((response) => {
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
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addPlaylist() {
      console.log("addPlaylist");
      this.isOpenCreating = true;
    },
    handleCloseCreate() {
      this.isOpenCreating = false;
    },
    cancelNew() {
      this.isOpenCreating = false;
    },
    acceptCreation() {
      this.apiService
        .createPlaylist(this.newPlaylistName)
        .then((response) => {
          this.toast = true;
          this.toastSuccess = true;
          this.toastMessage = "Playlist created successfully";
          this.$emit("created");
          setTimeout(() => {
            this.toast = false;
            this.toastSuccess = false;
            this.toastMessage = "";
          }, 3000);
          console.log(response);
        })
        .catch((error) => {
          this.toast = true;
          this.toastError = true;
          this.toastMessage = error.response.data.message;
          setTimeout(() => {
            this.toast = false;
            this.toastError = false;
            this.toastMessage = "";
          }, 3000);
        });
      this.isOpenCreating = false;
    },
  },

  mounted() {
    this.token = this.apiService.getToken();
    console.log(this.playlists);
  },
};
</script>

<template>
  <div>
    <div class="container">
      <div class="toolbar">
        <h3 class="title-azul">Playlists</h3>
        <img
          src="../assets/icons/crossAzul.svg"
          @click="close()"
          class="cruz"
        />
      </div>
      <!-- Playlists -->
      <div class="playlists" v-if="token">
        <div class="playlist" v-for="playlist in playlists" :key="playlist.id">
          <div class="playlist-header">
            <img
              src="../assets/icons/removeLike.svg"
              class="dislike-icon"
              @click="openDialog(playlist.id, 0)"
            />
            <p class="f-Cat f-1-5" @click="toggleSongs(playlist.id)">
              {{ playlist.name }}
            </p>
            <img
              src="../assets/icons/playNegro.svg"
              class="play-icon"
              @click="playSong(playlist.id, playlist.songs[0].id)"
            />
          </div>
          <!-- Canciones -->
          <div class="canciones" v-show="showSongs[playlist.id]">
            <div class="cancion" v-for="song in playlist.songs" :key="song.id">
              <img
                src="../assets/icons/removeLike.svg"
                class="dislike-icon"
                @click="openDialog(playlist.id, song.id)"
              />
              <p class="f-Cat f-20p">
                <span class="f-Marck">{{ song.name }}</span> -
                {{
                  song.artist.name == "NoArtist"
                    ? "Artista Desconocido"
                    : song.artist.name
                }}
              </p>
              <img
                src="../assets/icons/playNegro.svg"
                class="play-icon"
                @click="playSong(playlist.id, song.id)"
              />
            </div>
          </div>
        </div>
        <img src="../assets/icons/addBlanco.svg" @click="addPlaylist()" />
      </div>
    </div>

    <p class="azul" v-if="!token">LogIn to see your Playlist</p>

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
    <!-- Modal eliminar PL y canciones -->
    <div v-if="isOpen" class="dialog-backdrop">
      <dialog :open="isOpen" @close="handleClose" class="custom-dialog">
        <p class="f-Marck f-15">{{ dialogText }}</p>
        <div class="dialog-butons">
          <button class="boton-cancelar" @click="cancel">No</button>
          <button class="boton" @click="accept">Yes</button>
        </div>
      </dialog>
    </div>
    <!-- modal crear playlist -->
    <div v-if="isOpenCreating" class="dialog-backdrop">
      <dialog
        :open="isOpenCreating"
        @close="handleCloseCreate"
        class="custom-dialog"
      >
        <p class="f-Marck f-15">Name of the playlist</p>
        <input type="text" v-model="newPlaylistName" class="input" />
        <div class="dialog-butons">
          <button class="boton-cancelar" @click="cancelNew">Cancel</button>
          <button
            class="boton"
            @click="acceptCreation"
            :disabled="!newPlaylistName"
          >
            Create
          </button>
        </div>
      </dialog>
    </div>
  </div>
</template>

<style scoped src="../assets/styles/playlist.css"></style>
