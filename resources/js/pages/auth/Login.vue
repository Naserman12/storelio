<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-xl shadow w-96">
      <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

      <form @submit.prevent="login">
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full mb-4 p-2 border rounded"
        />

        <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="w-full mb-4 p-2 border rounded"
        />

        <button class="w-full bg-blue-500 text-white p-2 rounded">
          Login
        </button>
      </form>

      <p v-if="error" class="text-red-500 mt-4 text-sm">
        {{ error }}
      </p>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../../api/api'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

async function login() {
  try {
    const res = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    // حفظ التوكن
    localStorage.setItem('token', res.data.token)

    // تحويل للداشبورد
    router.push('/')

  } catch (err) {
    error.value = 'Invalid credentials'
  }
}
</script>