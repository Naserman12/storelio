<template>
  <div>

    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <!-- Loading -->
    <div v-if="loading">Loading...</div>

    <!-- Data -->
    <div v-else>

      <!-- Stats -->
      <div class="grid grid-cols-4 gap-6">

        <div class="card">
          <p>Products</p>
          <h2>{{ stats.products_count }}</h2>
        </div>

        <div class="card">
          <p>Orders</p>
          <h2>{{ stats.orders_count }}</h2>
        </div>

        <div class="card">
          <p>Sales</p>
          <h2>{{ stats.total_sales }}</h2>
        </div>

        <div class="card">
          <p>Customers</p>
          <h2>{{ stats.customers_count }}</h2>
        </div>

      </div>

      <!-- Latest Orders -->
      <div class="mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Latest Orders</h2>

        <table class="w-full">
          <thead>
            <tr class="border-b">
              <th>ID</th>
              <th>Total</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="order in stats.latest_orders" :key="order.id">
              <td>#{{ order.id }}</td>
              <td>{{ order.total }}</td>
              <td :class="order.status === 'paid' ? 'text-green-500' : 'text-yellow-500'">{{ order.status }}</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'

const stats = ref({})
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get('/dashboard')
    stats.value = res.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
})
</script>

<style>
.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
</style>