<script lang="ts">

import NavBar from './components/NavBar.vue';
import UserFlowC from './components/UserFlowC.vue';
import { apiService } from './services/apiService';
import FavoritesC from './components/FavoritesC.vue';
import PlaylistC from './components/PlaylistC.vue';
import SearchC from './components/SearchC.vue';

//modelos
import { Playlist, Favorite, Song, Artist, Genre } from "./models/AllModels"
export default {
  components: {
    NavBar,
    UserFlowC,
    FavoritesC,
    PlaylistC,
    SearchC
  },

  data() {
    return {
      apiService: new apiService(), //apiService
      login: false,
      fav: false,
      playli: false,
      user: 'account',
      token: '',
      favorites: [] as Favorite[],
      playlists: [] as Playlist[],
      songs: [] as Song[],
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
      this.user = 'user';
      console.log('sesion iniciada');
    },
    getFavorites(){
      this.apiService.getAllFavorites(this.token).then((response) => {
        this.favorites = response.data;
      }).catch((error) => {
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
    getSongs(){
      this.apiService.getAllSongs().then((response) => {
        this.songs = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  },

  mounted() {
    this.token = this.apiService.getToken();
    this.getSongs();
    if(this.token){
      this.getFavorites()
      this.getPlaylist();
    }
  },

};
</script>

<template>
    <div class="main">
        <NavBar @accClicked="handleLogin()" :user="user" @favClicked="handleFav()" @plClicked="handlePlaylist()"></NavBar>
        <Transition >
          <UserFlowC v-if="login" @close="() => login=false" @logged="handleLog"></UserFlowC>
        </Transition>
        <Transition>
          <FavoritesC v-if="fav" @close="() => fav=false" @removed="getFavorites()" :favorites="favorites"></FavoritesC>
        </Transition>
        <Transition>
          <PlaylistC v-if="playli" @close="() => playli=false" @removed="getPlaylist()" :playlists="playlists"></PlaylistC>
        </Transition>
    </div>
</template>

<style src="./assets/styles/main.css">

</style>
