<template>
  <div>

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6">Orders</h1>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

      <table class="w-full">

        <thead class="bg-gray-50 text-gray-600">
          <tr>
            <th class="p-3 text-left">#</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>

          <tr
            v-for="o in orders"
            :key="o.id"
            class="border-t hover:bg-gray-50"
          >
            <td class="p-3">#{{ o.id }}</td>

            <td>{{ o.user?.name || 'Guest' }}</td>

            <td class="font-medium">{{ o.total }}</td>

            <!-- Status -->
            <td>
              <span :class="statusClass(o.status)">
                {{ o.status }}
              </span>
            </td>

            <td>{{ formatDate(o.created_at) }}</td>

            <td>
              <button
                @click="openDetails(o)"
                class="text-blue-600 hover:underline"
              >
                View
              </button>
            </td>

          </tr>

        </tbody>

      </table>

    </div>

    <!-- Modal التفاصيل -->
    <div v-if="selectedOrder" class="fixed inset-0 bg-black/40 flex items-center justify-center">

      <div class="bg-white w-full max-w-lg rounded-xl p-6">

        <h2 class="text-xl font-semibold mb-4">
          Order #{{ selectedOrder.id }}
        </h2>

        <!-- Items -->
        <div class="space-y-2 mb-4">

          <div
            v-for="item in selectedOrder.items"
            :key="item.id"
            class="flex justify-between border-b pb-2"
          >
            <span>{{ item.product?.name }}</span>
            <span>x{{ item.quantity }}</span>
          </div>

        </div>

        <!-- تغيير الحالة -->
        <select
          v-model="selectedOrder.status"
          class="w-full border p-2 rounded mb-4"
        >
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
          <option value="shipped">Shipped</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>

        <!-- Actions -->
        <div class="flex justify-end gap-2">
          <button @click="selectedOrder=null">Close</button>

          <button
            @click="updateStatus"
            class="bg-blue-600 text-white px-4 py-1 rounded"
          >
            Update
          </button>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/api'
import { showToast } from '../stores/toast'

const orders = ref([])
const selectedOrder = ref(null)

// 🟢 جلب الطلبات
async function fetchOrders() {
  const res = await api.get('/orders')
  orders.value = res.data
}

// 🟢 فتح التفاصيل
function openDetails(order) {
  selectedOrder.value = JSON.parse(JSON.stringify(order))
}

// 🟢 تحديث الحالة
async function updateStatus() {
  await api.put(`/orders/${selectedOrder.value.id}`, {
    status: selectedOrder.value.status
  })

  showToast('Order updated', 'success')
  selectedOrder.value = null
  fetchOrders()
}

// 🎨 تنسيق الحالة
function statusClass(status) {
  return {
    'px-2 py-1 rounded text-sm bg-yellow-100 text-yellow-700': status === 'pending',
    'px-2 py-1 rounded text-sm bg-green-100 text-green-700': status === 'paid',
    'px-2 py-1 rounded text-sm bg-blue-100 text-blue-700': status === 'shipped',
    'px-2 py-1 rounded text-sm bg-gray-200 text-gray-700': status === 'completed',
    'px-2 py-1 rounded text-sm bg-red-100 text-red-700': status === 'cancelled',
  }
}

// 🕒 تنسيق التاريخ
function formatDate(date) {
  return new Date(date).toLocaleDateString()
}

onMounted(fetchOrders)
</script>