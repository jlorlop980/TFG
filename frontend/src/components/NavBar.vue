// nav with login, favorites, playlist and search
<script lang="ts">
interface Props {
  user: string;
}
export default {
  
  props: {
    user: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      count: 0
    }
  },


  methods: {
    clickedPlaylist() {
        this.$emit('plClicked');
        console.log(1);
    },
    clickedFavorites() {
        this.$emit('favClicked');
        console.log(2);
    },
    clickedSearch() {
        this.$emit('shClicked');
        console.log(3);
    },
    clickedAccount() {
        this.$emit('accClicked');
        console.log(4);
    },
    clickedTitle() {
        this.$emit('tClicked');
        console.log(5)
    }

  },


  mounted() {
    console.log(`The initial count is ${this.count}.`)
  }
}
</script>

<template>
    <div class="navbar">
        <p class="element" v-on:click="clickedPlaylist">Playlist</p>
        <p class="element" v-on:click="clickedFavorites">Favorites</p>
        <p class="element titleNavbar" v-on:click="clickedTitle">Lofi Player</p>
        <p class="element" v-on:click="clickedAccount">{{user}}</p>
        <p class="element" v-on:click="clickedSearch">Search</p>
    </div>
</template>

<style scoped src="../assets/styles/navbar.css">
</style>