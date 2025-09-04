// src/stores/auth.js
import { defineStore } from "pinia"
import api from "@/lib/axios" // <-- import axios instance

interface AuthState {
  user: any | null
  token: string | null
  isAuthenticated: boolean
  loading: boolean
  error: string | null
}

export const useAuthStore = defineStore("auth", {
  state: (): AuthState => ({
    user: null,
    token: null,
    isAuthenticated: false,
    loading: false,
    error: null,
  }),

  actions: {
    async register(payload: any) {
      this.loading = true
      this.error = null
      try {
        const response = await api.post("/auth/register", payload)
        console.log("Laravel register response:", response)

        // Assume Laravel returns { user, token }
        const { user, token } = response.data

        this.user = user
        this.token = token
        this.isAuthenticated = true

        // persist
        localStorage.setItem("token", token)
        localStorage.setItem("user", JSON.stringify(user))

        return response.data
      } catch (err: any) {
            console.error("Laravel validation response:", err.response?.data)
            this.error = err.response?.data?.errors || err.response?.data?.message
            throw err
        } finally {
        this.loading = false
        }
    },

    async login(payload: { email: string; password: string }) {
        this.loading = true
        this.error = null
        console.log("Login payload:", payload)
        try {
            
            const response = await api.post("/auth/login", payload)
            console.log("Laravel login response:", response.data)

            const { user, access_token } = response.data // <--- use access_token

            this.user = user
            this.token = access_token
            this.isAuthenticated = true

            localStorage.setItem("token", access_token)
            localStorage.setItem("user", JSON.stringify(user))

            return response.data
        } catch (err: any) {
            console.error("Laravel login error:", err.response?.data)
            this.error = err.response?.data?.errors || err.response?.data?.message
            throw err
        } finally {
            this.loading = false
        }
},


    logout() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      localStorage.removeItem("token")
      localStorage.removeItem("user")
    },

    loadUserFromStorage() {
      const token = localStorage.getItem("token")
      const user = localStorage.getItem("user")

      if (token && user) {
        this.token = token
        this.user = JSON.parse(user)
        this.isAuthenticated = true
      }
    },
  },
})
