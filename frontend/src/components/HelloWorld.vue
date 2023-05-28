<script setup lang="ts">

import { ref } from 'vue'
import { apiService } from '../services/apiService'
import  NavBar  from './NavBar.vue'

defineProps<{ msg: string }>()

// const api= new apiService();
// api.getAllSongs().then((res:any) => {
//   console.log(res);
// });

const count = ref(0)

</script>

<template>
  <NavBar></NavBar>

</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
