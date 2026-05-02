import { createRouter, createWebHistory } from 'vue-router'

import DashboardLayout from '../layouts/DashboardLayout.vue'

// import Dashboard from '../pages/Dashboard.vue'
// import Products from '../pages/Products.vue'
// import Orders from '../pages/Orders.vue'
// import Categories from '../pages/Categories.vue'
// import Settings from '../pages/Settings.vue'
// import Login from '../pages/Login.vue'

const routes = [
//   { path: '/login', component: Login },

  {
    path: '/',
    component: DashboardLayout,
    // children: [
    //   { path: '', component: Dashboard },
    //   { path: 'products', component: Products },
    //   { path: 'orders', component: Orders },
    //   { path: 'categories', component: Categories },
    //   { path: 'settings', component: Settings },
    // ]
  }
]

export default createRouter({
  history: createWebHistory(),
  routes
})