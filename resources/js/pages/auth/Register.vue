<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-6 rounded-xl shadow w-full max-w-md">

      <h1 class="text-2xl font-bold mb-6 text-center">Create Account</h1>

      <form @submit.prevent="register">

        <input v-model="name" placeholder="Name"
          class="w-full mb-3 p-2 border rounded" />

        <input v-model="email" type="email" placeholder="Email"
          class="w-full mb-3 p-2 border rounded" />

        <input v-model="password" type="password" placeholder="Password"
          class="w-full mb-3 p-2 border rounded" />

        <button class="w-full bg-green-500 text-white p-2 rounded">
          Register
        </button>

      </form>

      <p v-if="error" class="text-red-500 mt-3 text-sm">
        {{ error }}
      </p>

    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../../api/api'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

async function register() {
  try {
    await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      role: 'owner'
    })

     // 🔥 نرسله لصفحة إنشاء متجر
    // router.push('/create-store')

  } catch (e) {
    error.value = 'Registration failed';
    console.log('Error Registration', e);
  }
}
</script>