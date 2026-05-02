import { createRouter, createWebHistory } from 'vue-router'

import DashboardLayout from '../layouts/DashboardLayout.vue'

import Dashboard from '../pages/Dashboard.vue'
import Login from '../pages/auth/Login.vue'


import Products from '../pages/Products.vue'
import Orders from '../pages/Orders.vue'
import Categories from '../pages/Categories.vue'
import Settings from '../pages/Settings.vue'
import StoreFront from '../pages/StoreFront.vue'
import Cart from '../pages/Cart.vue'
import Register from '../pages/auth/Register.vue'

const routes = [
  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/store', component: StoreFront},
  { path: '/cart', component: Cart},
  {
    path: '/',
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

export default createRouter({
  history: createWebHistory(),
  routes
})