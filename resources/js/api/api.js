import axios from 'axios'

const api = axios.create({
 baseURL: import.meta.env.VITE_API_URL,
})

api.interceptors.request.use(config => {
    const token = localStorage.getItem('token')

  if (token && !['/login', '/register'].includes(config.url)) {
    config.headers.Authorization = `Bearer ${token}`
  }
  // config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
  
  return config
})

export default api