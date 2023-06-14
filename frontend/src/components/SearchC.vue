<script lang="ts">
import { Genre } from "../models/AllModels";
import { Artist } from "../models/Artist";
import { Song } from "../models/Song";
import { apiService } from "../services/apiService";

interface Props {
  songs: Song[];
}

export default {
  props: {
    songs: {
      type: Array as () => Song[],
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
      genres: [] as Genre[], //Genre[]
      artists: [] as Artist[], //Artist[]
      selectedArtist: "all",  // Artista seleccionado
      selectedGenre: "all",   // Género seleccionado
      searchName: '',  // Nombre de búsqueda
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    playClicked(id:number) {
      console.log("playClicked");
      this.$emit("playClick",id);
    },
    getData() {
      this.apiService
        .getAllGenres()
        .then((res) => {
          this.genres = res.data;
        })
        .catch((err) => {
          this.toast = true;
          this.toastError = true;
          this.toastMessage = err.response.data.message;
        });
      this.apiService
        .getAllArtists()
        .then((res) => {
          this.artists = res.data;
        })
        .catch((err) => {
          this.toast = true;
          this.toastError = true;
          this.toastMessage = err.response.data.message;
        });
    },
  },

  mounted() {
    this.token = this.apiService.getToken();
    this.getData();
  },

  computed: {
    filteredSongs() {
      // Aplicar filtros según los valores seleccionados
      let filtered = this.songs;

      if (this.selectedArtist !== 'all') {
        const artistId = parseInt(this.selectedArtist);
        filtered = filtered.filter(song => song.artist.id === artistId);
      }

      if (this.selectedGenre !== 'all') {
        const genreId = parseInt(this.selectedGenre);
        filtered = filtered.filter(song => song.genre.id === genreId);
      }

      if (this.searchName) {
        filtered = filtered.filter(song => song.name.toLowerCase().includes(this.searchName.toLowerCase()));
      }

      return filtered;
    },
  },
};
</script>

<template>
  <div>
    <div class="container">
      <div class="toolbar">
        <h3 class="title">Search</h3>
        <img
          src="../assets/icons/crossBlanco.svg"
          @click="close()"
          class="cruz"
        />
      </div>

      <!-- Search -->
      <div class="options">
        <div class="top-group">
          <div class="input-group">
            <span class="input-group-addon">
              <img class="icono" src="../assets/icons/user.svg" />
            </span>
            <select name="artist" class="f-Marck" v-model="selectedArtist">
              <option value="all">All Artists</option>
              <option :value="artist.id" v-for="artist in artists">
                {{ artist.name }}
              </option>
            </select>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <img class="icono" src="../assets/icons/mic.svg" />
            </span>
            <select name="genre" class="f-Marck" v-model="selectedGenre">
              <option value="all">All Genres</option>
              <option :value="genre.id" v-for="genre in genres">
                {{ genre.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="input-group">
          <span class="input-group-addon">
            <img class="icono" src="../assets/icons/magnifier.svg" />
          </span>
          <input type="text" placeholder="Name" class="f-Marck" v-model="searchName"/>
        </div>
      </div>
      <div class="songs">
      <div v-for="song in filteredSongs" :key="song.id" class="song">
        
        <p><span class="f-Marck">{{ song.name }}</span> - {{ song.artist.name }}</p>
        <img src="../assets/icons/playNegro.svg" @click="playClicked(song.id)">
      </div>
    </div>
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
  </div>
</template>

<style scoped src="../assets/styles/search.css"></style>
