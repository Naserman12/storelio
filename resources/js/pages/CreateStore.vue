<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-6 rounded shadow w-full max-w-md">

      <h1 class="text-xl font-bold mb-4">Create Your Store</h1>

      <input
        v-model="name"
        placeholder="Store Name"
        class="w-full p-2 border rounded mb-4"
      />

      <button
        @click="createStore"
        class="w-full bg-blue-500 text-white p-2 rounded"
      >
        Create Store
      </button>

    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../api/api'
import { useRouter } from 'vue-router'

const name = ref('')
const router = useRouter()

async function createStore() {
    try {
        await api.post('/stores', {
          name: name.value
        })      
        router.push('/dashboard')
    } catch (error) {
        console.log('Error Srore => ',error)
    }
}
</script>