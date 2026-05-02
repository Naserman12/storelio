import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', {
  state: () => ({
    message: '',
    show: false
  }),

  actions: {
    success(msg) {
      this.message = msg
      this.show = true

      setTimeout(() => this.show = false, 3000)
    }
  }
})