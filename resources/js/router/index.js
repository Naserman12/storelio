import { createRouter, createWebHistory } from 'vue-router'
import api from '../api/api'

import Dashboard from '../pages/Dashboard.vue'
import Login from '../pages/auth/Login.vue'


import Products from '../pages/Products.vue'
import Orders from '../pages/Orders.vue'
import Categories from '../pages/Categories.vue'
import Settings from '../pages/Settings.vue'
import StoreFront from '../pages/StoreFront.vue'
import Cart from '../pages/Cart.vue'
import Register from '../pages/auth/Register.vue'
import Landing from '../pages/Landing.vue'
import CreateStore from '../pages/CreateStore.vue'
import DashboardLayout from '../layouts/DashboardLayout.vue'

const routes = [

  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/create-store', component: CreateStore },
  { path: '/store', component: StoreFront},
  { path: '/cart', component: Cart},
    {path: '/',
    component: Landing,},
  {
    path: '/dashboard',
    component: DashboardLayout,
    
    children: [
      { path: '', component: Dashboard },
      { path: 'products', component: Products },
      { path: 'orders', component: Orders },
      { path: 'categories', component: Categories },
      { path: 'settings', component: Settings },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token') || null

 // صفحات عامة (ما تحتاج تسجيل)
  const publicPages = ['/', '/login', '/register']

  if (!token && !publicPages.includes(to.path)) {
    return next('/login')
  }

  if (token) {
    try {
      // تحقق من وجود متجر
      const res = await api.get('/store')
      // إذا ما عنده متجر → حوله لإنشاء متجر
      if (!res.data.store && to.path !== '/create-store') {
        return next('/create-store')
      }
      // إذا عنده متجر وهو في create-store → رجعه للداشبورد
      if (res.data.store && to.path === '/create-store') {
        return next('/dashboard')
      }
    } catch (e) {
      // إذا التوكن خرب
      localStorage.removeItem('token')
      console.log('Error index Failed',e)
      return next('/login')
    }
  }
  next()

})
export default router