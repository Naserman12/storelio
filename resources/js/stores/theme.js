import { defineStore } from 'pinia'
import api from '../api/api'

export const useThemeStore = defineStore('theme', {
  state: () => ({
    theme: 'light',
    loaded: false
  }),

  actions: {

    // 🟢 جلب من السيرفر
    async fetchTheme() {
      const res = await api.get('/settings')
      this.theme = res.data.theme || 'light'
      this.loaded = true
    },

    // 🟢 تغيير الثيم
    async setTheme(theme) {
      this.theme = theme

      await api.post('/settings', {
        key: 'theme',
        value: theme
      })
    }
  }
})