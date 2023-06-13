//controls of the song currently playing
<script lang="ts">
import { Playlist, Song } from "../models/AllModels";

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
    };
  },

  // Methods are functions that mutate state and trigger updates.
  // They can be bound as event listeners in templates.
  methods: {
    playNext() {
      if (this.currentSongIndex !== -1) {
        if (this.playbackMode && this.playlist.songs.length > 0) {
          let nextIndex = this.currentSongIndex + 1;

          if (nextIndex >= this.playlist.songs.length) {
            nextIndex = 0; // Volver al inicio de la playlist
          }
        } else {
          let nextIndex = this.currentSongIndex + 1;

          if (nextIndex >= this.songs.length) {
            nextIndex = 0; // Volver al inicio de todas las canciones
          }
        }
      }
    },
    playPrevious() {
      if (this.currentSongIndex !== -1) {
        if (this.playbackMode && this.playlist.songs.length > 0) {
          let prevIndex = this.currentSongIndex - 1;

          if (prevIndex < 0) {
            prevIndex = this.playlist.songs.length - 1; // Ir al final de la playlist
          }
        } else {
          let prevIndex = this.currentSongIndex - 1;

          if (prevIndex < 0) {
            prevIndex = this.songs.length - 1; // Ir al final de todas las canciones
          }
        }
      }
    },
  },
  computed: {
    currentSongIndex() {
      if (this.currentSong) {
        if (this.playbackMode) {
          return this.playlist.songs.findIndex(
            (song) => song.id === this.currentSong.id
          );
        } else {
          return this.songs.findIndex(
            (song) => song.id === this.currentSong.id
          );
        }
      }
      return -1;
    },
  },
  watch: {
    currentSong() {
      this.cancion.src = this.currentSong.url;
    },
    playlist() {
      this.cancion.src = this.currentSong.url;
    },
  },

  mounted() {
    this.cancion.src = this.currentSong.url;
  },
};
</script>

<template></template>

<style scoped></style>
