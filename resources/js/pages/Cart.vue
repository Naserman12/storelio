<template>
  <div class="p-6">

    <h1 class="text-2xl font-bold mb-6">🛒 My Cart</h1>

    <div v-if="!cart || cart.items.length === 0">
      <p class="text-gray-500">Your cart is empty</p>
    </div>

    <div v-else class="space-y-4">

      <div
        v-for="item in cart.items"
        :key="item.id"
        class="flex justify-between items-center bg-white p-4 rounded shadow"
      >

        <div>
          <h2 class="font-semibold">
            {{ item.product.name }}
          </h2>

          <p class="text-sm text-gray-500">
            Quantity: {{ item.quantity }}
          </p>
        </div>

        <button
          @click="remove(item.id)"
          class="text-red-500"
        >
          Remove
        </button>

      </div>

      <!-- Clear Cart -->
      <button
        @click="clearCart"
        class="mt-6 bg-red-500 text-white px-4 py-2 rounded"
      >
        Clear Cart
      </button>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'
import { showToast } from '../stores/toast'

const cart = ref(null)

// 🟢 جلب السلة
async function fetchCart() {
  const res = await api.get('/cart')
  cart.value = res.data
}

// 🟢 حذف عنصر
async function remove(id) {
  await api.delete(`/cart/item/${id}`)
  showToast('Removed', 'success')
  fetchCart()
}

// 🟢 تفريغ
async function clearCart() {
  await api.post('/cart/clear')
  showToast('Cart cleared', 'success')
  fetchCart()
}

onMounted(fetchCart)
</script>