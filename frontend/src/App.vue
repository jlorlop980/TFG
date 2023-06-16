<script lang="ts">
import NavBar from "./components/NavBar.vue";
import UserFlowC from "./components/UserFlowC.vue";
import { apiService } from "./services/apiService";
import FavoritesC from "./components/FavoritesC.vue";
import PlaylistC from "./components/PlaylistC.vue";
import SearchC from "./components/SearchC.vue";
import ControlsC from "./components/ControlsC.vue";

//modelos
import { Playlist, Favorite, Song, Artist, Genre } from "./models/AllModels";

export default {
  components: {
    NavBar,
    UserFlowC,
    FavoritesC,
    PlaylistC,
    SearchC,
    ControlsC,
  },

  data() {
    return {
      apiService: new apiService(), //apiService
      login: false,
      fav: false,
      playli: false,
      playbackMode: false,
      user: "Login",
      token: "",
      searc: false,
      isLoading: true,
      favorites: [] as Favorite[],
      playlists: [] as Playlist[],
      playlist: {} as Playlist,
      songs: [] as Song[],
      currentSong: {} as Song,
      toast: false,
      toastError: false,
      toastSuccess: false,
      toastMessage: "",
      isOpenCreating: false,
      addedPlaylistid:0,
    };
  },

  methods: {
    handleLogin() {
      this.login = !this.login;
      console.log(this.login);
    },
    addFav(){
      if(this.token != ""){
      this.apiService.setToken();
      this.apiService.addFavorite(this.currentSong.id).then((response) => {
        this.toast = true;
        this.toastSuccess = true;
        this.toastMessage = "Favorite added successfully";
        this.getFavorites();
        setTimeout(() => {
          this.toast = false;
          this.toastSuccess = false;
          this.toastMessage = "";
        }, 3000);
        console.log(response);
      }).catch((error) => {
        this.toast = true;
        this.toastError = true;
        this.toastMessage = "Alredy in favorites";
        setTimeout(() => {
          this.toast = false;
          this.toastError = false;
          this.toastMessage = "";
        }, 3000);
      });
    }else{
      this.toast = true;
      this.toastError = true;
      this.toastMessage = "You must be logged in";
      setTimeout(() => {
        this.toast = false;
        this.toastError = false;
        this.toastMessage = "";
      }, 3000);
    }},

    handleFav() {
      this.fav = !this.fav;
      console.log(this.fav);
    },

    handlePlaylist() {
      this.playli = !this.playli;
      console.log(this.playli);
    },

    handleLog() {
      this.login = false;
      this.user = "LogOut";
      console.log("sesion iniciada");
      this.getFavorites();
      this.getPlaylist();
    },
    handleSearch() {
      this.searc = !this.searc;
    },

    getFavorites() {
      this.apiService
        .getAllFavorites(this.token)
        .then((response) => {
          this.favorites = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPlaylist() {
      this.apiService
        .getAllPlaylists()
        .then((response) => {
          this.playlists = response.data;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getSongs() {
      this.apiService
        .getAllSongs()
        .then((response) => {
          this.songs = response.data;
          this.currentSong = this.songs[0];
          console.log(this.songs);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateCurrentSong(id: number) {
      console.log("updateCurrentSong");
      this.playbackMode = false;
      let cancion = this.songs.find((song) => song.id === id);
      if (cancion) {
        this.currentSong = cancion;
      }
    },
    playNext() {
      if (this.playbackMode && this.playlist) {
        const currentIndex = this.playlist.songs.findIndex(
          (song) => song.id === this.currentSong.id
        );
        let nextIndex = currentIndex + 1;
        if (nextIndex >= this.playlist.songs.length) {
          nextIndex = 0; // Si es la última canción de la playlist, volvemos a la primera
        }
        this.currentSong = this.playlist.songs[nextIndex];
      } else {
        const currentIndex = this.songs.findIndex(
          (song) => song.id === this.currentSong.id
        );
        let nextIndex = currentIndex + 1;
        if (nextIndex >= this.songs.length) {
          nextIndex = 0; // Si es la última canción del conjunto global, volvemos a la primera
        }
        this.currentSong = this.songs[nextIndex];
      }
    },
    handleCloseCreate() {
      this.isOpenCreating = false;
    },
    playPrevious() {
      if (this.playbackMode && this.playlist) {
        const currentIndex = this.playlist.songs.findIndex(
          (song) => song.id === this.currentSong.id
        );
        let prevIndex = currentIndex - 1;
        if (prevIndex < 0) {
          prevIndex = this.playlist.songs.length - 1; // Si es la primera canción de la playlist, volvemos a la última
        }
        this.currentSong = this.playlist.songs[prevIndex];
      } else {
        const currentIndex = this.songs.findIndex(
          (song) => song.id === this.currentSong.id
        );
        let prevIndex = currentIndex - 1;
        if (prevIndex < 0) {
          prevIndex = this.songs.length - 1; // Si es la primera canción del conjunto global, volvemos a la última
        }
        this.currentSong = this.songs[prevIndex];
      }
    },
    handleLogout() {
      this.user = "Login";
      this.apiService.removeToken();
    },
    acceptCreation(){
      this.apiService.addSongToPlaylist(this.addedPlaylistid,this.currentSong.id).then((response) => {
        this.toast = true;
        this.toastSuccess = true;
        this.toastMessage = "Song added successfully";
        this.getPlaylist();
        setTimeout(() => {
          this.toast = false;
          this.toastSuccess = false;
          this.toastMessage = "";
          this.isOpenCreating = false;
        }, 3000);
        console.log(response);
      }).catch((error) => {
        this.toast = true;
        this.toastError = true;
        this.toastMessage = "Alredy in playlist";
        setTimeout(() => {
          this.toast = false;
          this.toastError = false;
          this.toastMessage = "";
        }, 3000);
      });
    },
    cancelNew() {
      this.isOpenCreating = false;
    },
    playPlaylist(playlistId: number, songId: number) {
      // Obtener la playlist seleccionada
      const playlist = this.playlists.find((p) => p.id === playlistId);
      if (!playlist) {
        // La playlist no existe
        return;
      }

      // Cambiar la playlist actual
      this.playlist = playlist;
      // Cambiar la canción actual según el ID recibido
      let check = playlist.songs.find((song) => song.id === songId);
      if (check) {
        this.currentSong = check;
      }

      // Cambiar el modo de reproducción a playlist
      this.playbackMode = true;
    },
    openCreate() {
      this.isOpenCreating = true;
    },
  },

  mounted() {
    this.token = this.apiService.getToken();
    this.getSongs();

    if (this.token) {
      this.getFavorites();
      this.getPlaylist();
      this.user = "LogOut";
    }
    setTimeout(() => {
      this.isLoading = false;
    }, 1000); // Delay de 2 segundos
  },
};
</script>

<template>
  <div class="main">
    <NavBar
      @accClicked="handleLogin()"
      :user="user"
      @favClicked="handleFav()"
      @plClicked="handlePlaylist()"
      @shClicked="handleSearch()"
      @logout="handleLogout()"
    ></NavBar>
    <Transition>
      <UserFlowC
        v-if="login"
        @close="() => (login = false)"
        @logged="handleLog"
      ></UserFlowC>
    </Transition>
    <Transition>
      <FavoritesC
        v-if="fav"
        @close="() => (fav = false)"
        @removed="getFavorites()"
        :favorites="favorites"
        @playClick="updateCurrentSong"
      ></FavoritesC>
    </Transition>
    <Transition>
      <PlaylistC
        v-if="playli"
        @close="() => (playli = false)"
        @removed="getPlaylist()"
        :playlists="playlists"
        @play="playPlaylist"
        @created="getPlaylist()"
      ></PlaylistC>
    </Transition>
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
    <Transition>
      <SearchC
        v-if="searc"
        :songs="songs"
        @close="() => (searc = false)"
        @playClick="updateCurrentSong"
      ></SearchC>
    </Transition>
    <ControlsC
      :currentSong="currentSong"
      :songs="songs"
      :playbackMode="playbackMode"
      :playlist="playlist"
      v-if="!isLoading"
      @next="playNext"
      @previous="playPrevious"
      @addFavorite="addFav"
      @addToPl="openCreate"
    ></ControlsC>
  </div>
  <!-- modal crear playlist -->
  <div v-if="isOpenCreating" class="dialog-backdrop">
      <dialog :open="isOpenCreating" @close="handleCloseCreate" class="custom-dialog">
        <p class="f-Marck f-15">Choose a Playlist</p>
        <select name="artist" class="f-Marck selectPL" v-model="addedPlaylistid">
              <option value=0>-</option>
              <option :value="playl.id" v-for="playl in playlists">
                {{ playl.name }}
              </option>
            </select>
        <div class="dialog-butons">
          <button class="boton-cancelar" @click="cancelNew">Cancel</button>
          <button class="boton" @click="acceptCreation"  :disabled="addedPlaylistid==0">Add</button>
        </div>
      </dialog>
    </div>
</template>

<style src="./assets/styles/main.css"></style>
