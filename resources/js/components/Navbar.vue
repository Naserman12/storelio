<template>
  <nav class="bg-white shadow px-4 py-3 flex justify-between items-center">

    <div class="font-bold text-lg">Storelio</div>

    <div class="hidden md:flex gap-4">
      <router-link to="/store">Home</router-link>
      <router-link to="/cart">Cart</router-link>
      <router-link to="#">Orders</router-link>
    </div>

    <div class="flex gap-3 items-center">

      <span class="text-sm text-gray-600 hidden sm:block">
        👤 User
      </span>

      <button
        @click="logout"
        class="text-red-500 text-sm"
      >
        Logout
      </button>

    </div>

  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>