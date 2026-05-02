<template>
  <div>

    <h1 class="text-2xl font-bold mb-6">Settings</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-md">

      <!-- Store Name -->
      <label class="block mb-2">Store Name</label>
      <input v-model="settings.store_name" class="input" />

      <!-- Theme -->
      <label class="block mt-4 mb-2">Theme</label>
      <select v-model="settings.theme" class="input">
        <option value="light">Light</option>
        <option value="dark">Dark</option>
        <option value="modern">Modern</option>
      </select>

      <button
        @click="save"
        class="mt-6 bg-blue-600 text-white px-4 py-2 rounded"
      >
        Save
      </button>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'
import { useToastStore } from '../stores/toast'

const toast = useToastStore()

const settings = ref({
  store_name: '',
  theme: 'light'
})

async function fetchSettings() {
  const res = await api.get('/settings')
  settings.value = res.data
}

async function save() {
  for (const key in settings.value) {
    await api.post('/settings', {
      key: key,
      value: settings.value[key]
    })
  }

  toast.success('Settings saved')
}

onMounted(fetchSettings)
</script>

<style>
.input {
  width: 100%;
  border: 1px solid #ddd;
  padding: 8px;
  border-radius: 6px;
}
</style>