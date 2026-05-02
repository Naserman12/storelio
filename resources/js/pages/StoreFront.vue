<template>
  <div class="p-6">

    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6">
      🛍️ {{ store.name }}
    </h1>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


      <div
        v-for="p in products"
        :key="p.id"
        class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition"
      >

        <!-- Image -->
        <img
          v-if="p.image"
          :src="`/storage/${p.image}`"
          class="w-full h-40 object-cover rounded-lg mb-3"
        />

        <!-- Name -->
        <h2 class="text-lg font-semibold">{{ p.name }}</h2>

        <!-- Price -->
        <p class="text-blue-600 font-bold mb-2">
          {{ p.price }} SAR
        </p>

        <!-- Add to cart -->
        <button
          class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800"
          @click="addToCart(p)"
        >
          Add to Cart
        </button>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'
import { useToastStore } from '../stores/toast'

const toast = useToastStore()

const products = ref([])
const store = ref({})

// 🟢 جلب بيانات المتجر + المنتجات
async function fetchData() {
  const [p, s] = await Promise.all([
    api.get('/public/products'),
    api.get('/public/store')
  ])

  products.value = p.data
  store.value = s.data
}

// 🟢 إضافة للسلا)
async function addToCart(product) {
  await api.post('/cart/add', {
    product_id: product.id,
    quantity: 1
  })
  toast.success('Added to cart 🛒')
}

onMounted(fetchData)
</script>