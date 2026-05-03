<template>
  <div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Categories</h1>

      <button
        @click="openForm()"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg"
      >
        + Add Category
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow">

      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="p-3 text-left">Name</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="c in categories" :key="c.id" class="border-t">

            <td class="p-3">{{ c.name }}</td>

            <td class="space-x-2">
              <button @click="openForm(c)" class="text-blue-600">Edit</button>
              <button @click="deleteCategory(c.id)" class="text-red-500">Delete</button>
            </td>

          </tr>
        </tbody>
      </table>

    </div>

    <!-- Modal -->
    <div v-if="showForm" class="fixed inset-0 bg-black/40 flex items-center justify-center">

      <div class="bg-white p-6 rounded-xl w-80">

        <h2 class="mb-4 font-semibold">
          {{ isEdit ? 'Edit' : 'Add' }} Category
        </h2>

        <input
          v-model="form.name"
          placeholder="Category name"
          class="w-full border p-2 rounded mb-4"
        />

        <div class="flex justify-end gap-2">
          <button @click="showForm=false">Cancel</button>

          <button
            @click="save"
            class="bg-blue-600 text-white px-3 py-1 rounded"
          >
            Save
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

const categories = ref([])
const showForm = ref(false)
const isEdit = ref(false)

const form = ref({
  id: null,
  name: ''
})

// 🟢 جلب
async function fetchCategories() {
  const res = await api.get('/categories')
  categories.value = res.data
}

// 🟢 فتح
function openForm(cat = null) {
  if (cat) {
    isEdit.value = true
    form.value = { ...cat }
  } else {
    isEdit.value = false
    form.value = { name: '' }
  }

  showForm.value = true
}

// 🟢 حفظ
async function save() {
  if (isEdit.value) {
    await api.put(`/categories/${form.value.id}`, form.value)
    showToast('Updated', 'success')
  } else {
    await api.post('/categories', form.value)
    showToast('Created', 'success')
  }

  showForm.value = false
  fetchCategories()
}

// 🔴 حذف
async function deleteCategory(id) {
  await api.delete(`/categories/${id}`)
  showToast('Deleted', 'success')
  fetchCategories()
}

onMounted(fetchCategories)
</script>