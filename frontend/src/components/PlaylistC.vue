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
      showSongs: {} as { [key: number]: boolean },
    };
  },

  methods: {
    close() {
      this.$emit("close");
    },
    toggleSongs(playlistId: number) {
      this.showSongs[playlistId] = !this.showSongs[playlistId];
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
        });
    },
    playSong(playlistId: number, songId: number) {
      console.log("pulsado")
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
              @click="deletePlaylist(playlist.id)"
            />
            <p class="f-Cat f-1-5"  @click="toggleSongs(playlist.id)">{{ playlist.name }}</p>
            <img src="../assets/icons/playNegro.svg" class="play-icon" @click="playSong(playlist.id,playlist.songs[0].id)"/>
          </div>
          <!-- Canciones -->
          <div class="canciones" v-show="showSongs[playlist.id]">
            <div class="cancion" v-for="song in playlist.songs" :key="song.id">
              <img
                src="../assets/icons/removeLike.svg"
                class="dislike-icon"
                @click="deletePlaylistSong(playlist.id, song.id)"
              />
              <p class="f-Cat f-20p">
                <span class="f-Marck">{{ song.name }}</span> -
                {{
                  song.artist.name == "NoArtist"
                    ? "Artista Desconocido"
                    : song.artist.name
                }}
              </p>
              <img src="../assets/icons/playNegro.svg" class="play-icon" @click="playSong(playlist.id,song.id)"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p class="white" v-if="!token">LogIn to see your Playlist</p>
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
