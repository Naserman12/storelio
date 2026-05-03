<template>
  <div>

    <!-- عنوان -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Products</h1>

      <!-- <button
        @click="openForm"
        class="bg-blue-500 text-white px-4 py-2 rounded"
      >
        + Add Product
      </button> -->
    </div>

    <div class="flex justify-between items-center mb-6">

    <input
        v-model="search"
        placeholder="Search products..."
        class="border px-4 py-2 rounded-lg w-64 focus:ring-2 focus:ring-blue-500"
    />

    <button
        @click="openForm()"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
    >
        + Add Product
    </button>

    </div>
    <!-- Loading -->
    <div v-if="loading">Loading...</div>

    
    <!-- جدول -->
<table class="w-full bg-white rounded-xl shadow overflow-hidden">

  <thead class="bg-gray-50 text-gray-600 text-sm">
    <tr>
      <th class="p-3 text-left">Product</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <tr
      v-for="p in filteredProducts"
      :key="p.id"
      class="border-t hover:bg-gray-50 transition"
    >

      <td class="p-3 flex items-center gap-3">

        <!-- صورة -->
        <img
          v-if="p.image"
          :src="`/storage/${p.image}`"
          class="w-10 h-10 rounded object-cover"
        />

        <span>{{ p.name }}</span>
      </td>

      <td class="font-medium">{{ p.price }}</td>

      <td>
        <span class="px-2 py-1 bg-gray-100 rounded text-sm">
          {{ p.quantity }}
        </span>
      </td>

      <td class="space-x-2">

        <button
          @click="openForm(p)"
          class="text-blue-600 hover:underline"
        >
          Edit
        </button>

        <button
          @click="deleteProduct(p.id)"
          class="text-red-500 hover:underline"
        >
          Delete
        </button>

      </td>

    </tr>
  </tbody>

</table>

    <!-- Modal إضافة -->
<div v-if="showForm" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

  <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">

    <h2 class="text-xl font-semibold mb-4">
      {{ isEdit ? 'Edit Product' : 'Add Product' }}
    </h2>

    <!-- Name -->
    <input v-model="form.name"
      placeholder="Product Name"
      class="w-full border rounded-lg p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
    />

    <!-- Price -->
    <input v-model="form.price"
      placeholder="Price"
      class="w-full border rounded-lg p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
    />

    <!-- Quantity -->
    <input v-model="form.quantity"
      placeholder="Quantity"
      class="w-full border rounded-lg p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
    />

    <!-- Category -->
    <select v-model="form.category_id"
      class="w-full border rounded-lg p-2 mb-3 focus:ring-2 focus:ring-blue-500"
    >
      <option disabled value="">Select Category</option>
      <option v-for="c in categories" :key="c.id" :value="c.id">
        {{ c.name }}
      </option>
    </select>

    <!-- Image -->
    <input type="file"
      @change="handleImage"
      class="mb-4"
    />

    <!-- Actions -->
    <div class="flex justify-end gap-2">
      <button
        @click="showForm=false"
        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300"
      >
        Cancel
      </button>

      <button
        @click="saveProduct"
        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
      >
        Save
      </button>
    </div>

  </div>
</div>

  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '../api/api'
import { showToast } from '../stores/toast'

const products = ref([])
const categories = ref([])
const loading = ref(true)

const showForm = ref(false)
const isEdit = ref(false)

const search = ref('')

const form = ref({
  id: null,
  name: '',
  price: '',
  quantity: '',
  category_id: '',
  image: null
})

// 🔍 فلترة البحث
const filteredProducts = computed(() => {
  return products.value.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase())
  )
})

// 🟢 جلب البيانات
async function fetchData() {
  loading.value = true

  const [p, c] = await Promise.all([
    api.get('/products'),
    api.get('/categories')
  ])

  products.value = p.data.data
  categories.value = c.data

  loading.value = false
}

// 🟢 فتح الفورم
function openForm(product = null) {
  if (product) {
    isEdit.value = true
    form.value = { ...product }
  } else {
    isEdit.value = false
    form.value = {
      name: '',
      price: '',
      quantity: '',
      category_id: '',
      image: null
    }
  }

  showForm.value = true
}

// 🟢 حفظ (Add / Edit)
async function saveProduct() {
  const data = new FormData()

  data.append('name', form.value.name)
  data.append('price', form.value.price)
  data.append('quantity', form.value.quantity)
  data.append('category_id', form.value.category_id)

  if (form.value.image) {
    data.append('image', form.value.image)
  }

  if (isEdit.value) {
    data.append('_method', 'PUT')
    await api.post(`/products/${form.value.id}`, data)
  } else {
    await api.post('/products', data)
  }
  fetchData()
  showForm.value = false
}

// 🟢 حذف
async function deleteProduct(id) {
  if (!window.confirm('⚠️ This action cannot be undone. Continue?')) return

  try {
    await api.delete(`/products/${id}`)
    showToast('Deleted successfully', 'success')
    fetchData()
  } catch (e) {
    showToast('Delete failed', 'error')
  }
}

// 🟢 رفع صورة
function handleImage(e) {
  form.value.image = e.target.files[0]
}

onMounted(fetchData)
</script>
<style>
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
}

.box {
  background: white;
  padding: 20px;
  width: 400px;
  border-radius: 10px;
}

.input {
  width: 100%;
  border: 1px solid #ddd;
  padding: 8px;
  margin-bottom: 10px;
}
</style>