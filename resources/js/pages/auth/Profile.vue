<template>
  <div class="container mx-auto px-4 py-10">

    <!-- عنوان -->
    <h1 class="text-3xl font-bold mb-8 text-center">
      حسابي
    </h1>

    <div class="grid md:grid-cols-4 gap-8">

      <!-- القائمة الجانبية -->
      <div class="bg-white shadow rounded-xl p-5 space-y-3">

        <button
          v-for="item in menu"
          :key="item"
          @click="activeTab = item"
          :class="[
            'w-full text-right p-3 rounded-lg hover:bg-gray-100 transition',
            activeTab === item && 'bg-gray-900 text-white'
          ]"
        >
          {{ item }}
        </button>

        <button
          @click="logout"
          class="w-full text-right p-3 rounded-lg hover:bg-gray-100 transition text-red-500"
        >
          تسجيل الخروج
        </button>

      </div>

      <!-- المحتوى -->
      <div class="md:col-span-3 bg-white shadow rounded-xl p-6">
               <!-- معلوماتي -->
        <div v-if="activeTab === 'معلوماتي'">

          <div class="flex items-center gap-4 mb-6"
        :class="darkMode ? 'bg-gray-800' : 'bg-emerald-50'">
              <div class="relative cursor-pointer" @click="selectImage">

            <img
            :src="userAvatar || avatarPreview || defaultAvatar"
            class="w-16 h-16 rounded-full object-cover"
            />

            <div class="absolute inset-0 bg-black/40 rounded-full
                        flex items-center justify-center
                        text-white text-xs opacity-0 hover:opacity-100 transition">
            تغيير
            </div>

        </div>
                <input
            type="file"
            accept="image/*"
            ref="fileInput"
            class="hidden"
            @change="uploadAvatar"
        />

            <!-- <img
              src="https://i.pravatar.cc/100"
              class="w-16 h-16 rounded-full"
            /> -->
            <div>
              <h2 class="font-bold text-lg">{{ form.name }}</h2>
              <p class="text-gray-500">{{ form.email }}</p>
            </div>
          </div>

          <form @submit.prevent="updateProfile" class="space-y-4">

            <input
              v-model="form.name"
              placeholder="الاسم"
              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 outline-none"
            />

            <input
              v-model="form.email"
              placeholder="البريد الإلكتروني"
              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 outline-none"
            />
            <input
            v-model="form.phone"
            placeholder="رقم الجوال (اختياري)"
            class="w-full border rounded-lg px-3 py-2"
            />

            <button class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-black transition" :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-100'">
              حفظ التغييرات
            </button>

          </form>
        </div>

        <!-- الطلبات -->
        <div v-if="activeTab === 'طلباتي'">
          <p class="text-gray-500">
            لا توجد طلبات حالياً
          </p>
        </div>

        <!-- العناوين -->
        <div v-if="activeTab === 'العناوين'">
          <p class="text-gray-500">
            لم يتم إضافة عنوان بعد
          </p>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { showToast } from '../../stores/toast'
import api from '../../api/api'
import { useRouter } from 'vue-router'

const router = useRouter()

onMounted(() => {
  loadProfile()
})

const avatarPreview = ref(null)
const defaultAvatar = 'https://i.pravatar.cc/100'
const userAvatar = ref(null)
const user = ref(null);
const activeTab = ref('معلوماتي')

const menu = [
  'معلوماتي',
  'طلباتي',
  'العناوين'
]
//  تحميل بيانات الملف الشخصي
  const loadProfile = async () => {
    try {
    const res = await api.get("/user");
    user.value = res.data.data || res.data.user || res.data;
    console.log("Profile data =>", user.value)
    form.name = user.value.name
    form.email = user.value.email
    form.phone = user.value.phone


    } catch (e) {
      console.log("ERROR FULL:", e)
      console.log("ERROR RESPONSE:", e.response)
      console.log("ERROR DATA:", e.response?.data)
      showToast("حدث خطأ أثناء تحميل بيانات الملف الشخصي", "error")
      router.push("/login")
    }
  }

const form = reactive({
  name:"",
  email:"",
  phone:"",
})
const password = reactive({
  current_password:"",
  password:"",
  password_confirmation:""
})
const updateProfile = () => {
  showToast('تم تحديث البيانات ✅')
}

const logout = () => {
  localStorage.removeItem('user')
  showToast('تم تسجيل الخروج 👋')
}
</script>