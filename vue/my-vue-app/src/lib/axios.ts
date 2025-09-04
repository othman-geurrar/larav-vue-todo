import axios from "axios"

const api = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "application/json",
  },
})

// Optionally attach token automatically if stored
const token = localStorage.getItem("token")
if (token) api.defaults.headers.common["Authorization"] = `Bearer ${token}`

export default api
