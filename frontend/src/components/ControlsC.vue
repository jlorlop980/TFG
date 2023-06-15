//controls of the song currently playing
<script lang="ts">
import { Playlist, Song } from "../models/AllModels";
import { environment } from "../environments/enviroments";

interface Props {
  currentSong: Song;
  songs: Song[];
  playbackMode: Boolean;
  playlist: Playlist;
}
export default {
  // Properties returned from data() become reactive state
  // and will be exposed on `this`.
  props: {
    currentSong: {
      type: Object as () => Song,
      required: true,
    },
    songs: {
      type: Array as () => Song[],
      required: true,
    },
    playbackMode: {
      type: Boolean,
      required: true,
    },
    playlist: {
      type: Object as () => Playlist,
      required: true,
    },
  },
  data() {
    return {
      cancion: new Audio(),
      playing: false,
      volume: 0.5,
      currentTime: 0,
      duration: 0,
      progress: 0,
      muted: false,
      totalTime: 0,
      hover: false,
    };
  },

  // Methods are functions that mutate state and trigger updates.
  // They can be bound as event listeners in templates.
  methods: {
    reproduce() {
      //funcion para poner pausa o play
      if (!this.playing) {
        this.cancion.play();
      } else {
        this.cancion.pause();
      }
      this.playing = !this.playing;
    },
    addFavorite() {
      //funcion para añadir a favoritos
      this.$emit("addFavorite");
    },
    updateVol(event: any) {
      this.cancion.volume = this.volume;
      console.log(this.cancion.volume);
    },
    addToPl() {
      //funcion para añadir a playlist
      this.$emit("addToPl");
    },
    reset() {
      //funcion para reiniciar la cancion
      this.cancion.currentTime = 0;
    },
    playNext() {
      this.$emit("next");
    },
    playPrevious() {
      this.$emit("previous");
    },
    formatTime(time: any) {
      //aqui formateamos la fecha
      const minutes = Math.floor(time / 60);
      const seconds = Math.floor(time % 60);
      return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    },
    updateCurrentTime(event: any) {
      this.cancion.currentTime = event.target.value;
    },
    addEvents() {
      //aqui añadimos los eventos para poder usar tanto la barra de volumen como la de tiempo o el timepo como tal que se muestra

      this.cancion.addEventListener("timeupdate", () => {
        this.currentTime = this.cancion.currentTime;
      });
      this.cancion.addEventListener("loadedmetadata", () => {
        this.totalTime = this.cancion.duration;
      });
      this.cancion.addEventListener("ended", () => {
        console.log("Song has ended");
        this.playNext();
      });
    },
  },

  watch: {
    currentSong() {
      console.log("cambio de cancion");
      this.cancion.pause();
      this.playing = false;
      this.cancion.src = environment.API_URL_STORAGE + this.currentSong.url;
      this.addEvents();
      this.cancion.play();
      this.playing = true;
    },
    playlist() {
      this.cancion.src = environment.API_URL_STORAGE + this.currentSong.url;
    },
  },

  mounted() {
    console.log("cancion", this.currentSong);
    this.volume = this.cancion.volume;
    this.cancion.src = environment.API_URL_STORAGE + this.currentSong.url;
    this.addEvents();
    this.totalTime = this.cancion.duration;
  },
};
</script>

<template>
  <div class="container" v-if="currentSong">
    <!-- Nombre y artista -->
    <div class="names f-Marck" v-if="currentSong">
      <p class="data-name">{{ currentSong.name }}</p>
      <p class="data-artist">{{ currentSong.artist.name }}</p>
    </div>
    <!-- controles  -->
    <div class="controls">
      <!-- timestamsp reiniciar cancion y volumen -->
      <div class="controles-superiores">
        <!-- timestamps -->
        <div class="time f-Marck white">
          <p>{{ formatTime(currentTime) }} / {{ formatTime(totalTime) }}</p>
        </div>
        <!-- Reiniciar -barra- volumen -->
        <div class="reset-slider-vol">
          <img @click="reset" src="../assets/icons/replay.svg" />

          <input
            class="sliderTime"
            type="range"
            min="0"
            :max="totalTime"
            step="0.01"
            v-model="currentTime"
            @input="updateCurrentTime"
          />
          <div class="volControl">
            <img
              class="volume-icon"
              src="../assets/icons/vol.svg"
              @mouseenter="hover = true"
              @mouseleave="hover = false"
            />
            <input
              v-show="hover"
              class="volume barra"
              :class="hover"
              type="range"
              min="0"
              max="1"
              step="0.01"
              v-model="volume"
              @input="updateVol"
              @mouseenter="hover = true"
              @mouseleave="hover = false"
            />
          </div>
        </div>
      </div>
      <!-- Controles inferiores -->
      <!-- añadair a favoritos anterior, siguiente, play/pausa y añadir a playlist -->
      <div class="controles-inferiores">
        <img @click="addToPl" src="../assets/icons/addYellow.svg" />
        <p @click="playPrevious" class="white f-Marck">previous</p>
        <button class="play" v-on:click="reproduce">
          <img v-if="!playing" src="../assets/icons/playNegro.svg" class="icono-play"/>
          <img v-else src="../assets/icons/pause.svg" class="icono-play"/>
        </button>
        <p @click="playNext" class="white f-Marck">next</p>
        <img @click="addFavorite" src="../assets/icons/heart.svg" />
      </div>
    </div>
    
  </div>
</template>

<style scoped src="../assets/styles/controls.css"></style>
