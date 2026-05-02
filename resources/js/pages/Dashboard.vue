<template>
  <div>

    <!-- عنوان -->
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <!-- الكروت -->
    <div class="grid grid-cols-4 gap-6">

      <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Products</p>
        <h2 class="text-2xl font-bold mt-2">120</h2>
      </div>

      <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Orders</p>
        <h2 class="text-2xl font-bold mt-2">45</h2>
      </div>

      <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Sales</p>
        <h2 class="text-2xl font-bold mt-2">$15,230</h2>
      </div>

      <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Customers</p>
        <h2 class="text-2xl font-bold mt-2">30</h2>
      </div>

    </div>

    <!-- آخر الطلبات -->
    <div class="mt-10 bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-bold mb-4">Latest Orders</h2>

      <table class="w-full text-left">
        <thead>
          <tr class="border-b">
            <th class="py-2">Order ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>
          <tr class="border-b">
            <td class="py-2">#1</td>
            <td>Ali</td>
            <td>$120</td>
            <td class="text-green-500">Paid</td>
          </tr>

          <tr class="border-b">
            <td class="py-2">#2</td>
            <td>Ahmed</td>
            <td>$80</td>
            <td class="text-yellow-500">Pending</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script >
import api from '../api/api'

export async function getDashboard() {
  const res = await api.get('/admin/dashboard')
  return res.data
}
</script>