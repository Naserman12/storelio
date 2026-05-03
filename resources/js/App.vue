<script setup>
import { onMounted } from 'vue'
import { useThemeStore } from './stores/theme'
import Login from './pages/auth/Login.vue'
import { toastState } from './stores/toast'
import Navbar from './components/Navbar.vue'


const isLoggedIn = !!localStorage.getItem('token')
const themeStore = useThemeStore()

onMounted(() => {
  themeStore.fetchTheme()
})
</script>

<template>
  <Navbar/>
  <router-view />
  <div
    v-for="toast in toastState.toasts"
    :key="toast.id"
    :class="[
      'fixed bottom-5 right-5 text-white px-4 py-2 rounded shadow z-50',
      toast.type === 'success' ? 'bg-green-500' : 
      toast.type === 'error' ? 'bg-red-500' : 
      'bg-blue-500'
    ]"
  >
    {{ toast.message }}
  </div>
</template>