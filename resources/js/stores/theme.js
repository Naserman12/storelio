import { defineStore } from 'pinia'

export const useThemeStore = defineStore('theme', {
  state: () => ({
    theme: localStorage.getItem('theme') || 'light'
  }),

  actions: {
    setTheme(t) {
      this.theme = t
      localStorage.setItem('theme', t)
    }
  }
})