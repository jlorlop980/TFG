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
      favorites: [] as Favorite[],
      playlists: [] as Playlist[],
      playlist: {} as Playlist,
      songs: [] as Song[],
      currentSong: {} as Song,
    };
  },

  methods: {
    handleLogin() {
      this.login = !this.login;
      console.log(this.login);
    },

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
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateCurrentSong(id: number) {
      this.playbackMode = false;
      let cancion = this.songs.find((song) => song.id === id);
      if (cancion) {
        this.currentSong = cancion;
        // console.log("--------------------");
        // console.log("pulsada cancion", this.currentSong);
        // console.log("--------------------");
      }
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
      // console.log("--------------------");
      // console.log("pulsada playlist", this.playlist);
      // console.log("pulsada cancion", this.currentSong);
      // console.log("--------------------");

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
      ></PlaylistC>
    </Transition>
    <Transition>
      <SearchC
        v-if="searc"
        :songs="songs"
        @close="() => (searc = false)"
      ></SearchC>
    </Transition>
    <ControlsC :currentSong="currentSong" :songs="songs" :playbackMode="playbackMode" :playlist="playlist"></ControlsC>
  </div>
</template>

<style src="./assets/styles/main.css"></style>
