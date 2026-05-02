<script setup>
import { onMounted } from 'vue'
import { useThemeStore } from './stores/theme'
import Login from './pages/auth/Login.vue'
import { useToastStore } from './stores/toast'

const toast = useToastStore()
const themeStore = useThemeStore()

onMounted(() => {
  themeStore.fetchTheme()
})
</script>

<template>
  <router-view v-if="themeStore.loaded" />
  <Login v-else ></Login>
    <div
    v-if="toast.show"
    class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow"
  >
    {{ toast.message }}
  </div>
</template>