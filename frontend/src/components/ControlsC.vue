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
    
    this.cancion.src = environment.API_URL_STORAGE + this.currentSong.url;
    this.addEvents();
    this.totalTime = this.cancion.duration;
  },
};
</script>

<template>

  <div class="player">
    <div class="player-data" v-if="currentSong">
      <p class="data-name">{{ currentSong.name }}</p>
      <p class="data-artist">{{ currentSong.artist.name }}</p>
    </div>
    <input
    class="sliderTime"
    type="range"
    min="0"
    :max="totalTime"
    step="0.01"
    v-model="currentTime"
    @input="updateCurrentTime"
  />
    <button class="playbutton" v-on:click="reproduce">
      <img v-if="!playing" src="../assets/icons/playNegro.svg">
      <img v-else src="../assets/icons/pause.svg">
      </button>
  </div>
  <p @click="reset">reiniciar</p>
  <p @click="playPrevious">previous</p>
  <p @click="playNext">next</p>
</template>

<style scoped></style>
