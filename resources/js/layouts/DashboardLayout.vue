<template>
  <div :class="themeClass" class="flex h-screen">

    <!-- Sidebar -->
    <aside :class="themeClass" class="w-64  shadow-md p-4">
      <h1 class="text-xl font-bold mb-6">Storelio</h1>

      <nav class="space-y-3">
        <router-link to="/dashboard" class="block">📊 Dashboard</router-link>
        <router-link to="/products" class="block">📦 Products</router-link>
        <router-link to="/orders" class="block">🧾 Orders</router-link>
        <router-link to="/categories" class="block">🗂️ Categories</router-link>
        <router-link to="/settings" class="block">⚙️ Settings</router-link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <header :class="themeClass" class="shadow p-4 flex justify-between items-center">
            <h2 class="font-semibold">Dashboard</h2>
            <div>Welcome 👋</div>
          
        <div class="flex items-center gap-4">
          <span class="text-gray-600">👤 Admin</span>
          <button @click="logout" class="text-red-500 hover:underline">Logout</button>
        </div>
        <select @change="changeTheme" class="border p-1 rounded">
        <option value="light">Light</option>
        <option value="dark">Dark</option>
        <option value="modern">Modern</option>
        </select>
      </header>

      <!-- Page Content -->
      <main class="p-6 overflow-auto ">
        <router-view />
      </main>

    </div>

  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { computed } from 'vue'
import { useThemeStore } from '../stores/theme'
const themeStore = useThemeStore()

const themeClass = computed(() => {
  if (themeStore.theme === 'dark') {
    return 'bg-gray-900 text-white'
  }
  if (themeStore.theme === 'modern') {
    return 'bg-blue-200'
  }
  return 'bg-gray-100'
})
function changeTheme(e) {
  themeStore.setTheme(e.target.value)
}
function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>