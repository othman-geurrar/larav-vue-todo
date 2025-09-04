import { defineStore } from "pinia"
import api from "@/lib/axios" // axios instance with baseURL

export interface Task {
  id?: number
  name: string
  description?: string
  is_done?: boolean
  deadline?: string | null
  user_id: number
  created_at?: string
  updated_at?: string
}

interface TaskState {
  tasks: Task[]
  task: Task | null
  loading: boolean
  error: string | null
}

export const useTaskStore = defineStore("task", {
  state: (): TaskState => ({
    tasks: [],
    task: null,
    loading: false,
    error: null,
  }),

  actions: {
    /** Fetch all tasks */
    async fetchTasks() {
      this.loading = true
      this.error = null
      try {
        const response = await api.get("/tasks")
        this.tasks = response.data.data
      } catch (err: any) {
        console.error("Error fetching tasks:", err.response?.data)
        this.error = err.response?.data?.message || "Failed to fetch tasks"
      } finally {
        this.loading = false
      }
    },

    /** Fetch a single task */
    async fetchTask(id: number) {
      this.loading = true
      this.error = null
      try {
        const response = await api.get(`/tasks/${id}`)
        this.task = response.data.data
        return this.task
      } catch (err: any) {
        console.error("Error fetching task:", err.response?.data)
        this.error = err.response?.data?.message || "Failed to fetch task"
      } finally {
        this.loading = false
      }
    },

    /** Create a new task */
    async createTask(payload: Task) {
      this.loading = true
      this.error = null
      try {
        const response = await api.post("/tasks", payload)
        this.tasks.push(response.data.data)
        return response.data.data
      } catch (err: any) {
        console.error("Error creating task:", err.response?.data)
        this.error = err.response?.data?.message || "Failed to create task"
        throw err
      } finally {
        this.loading = false
      }
    },

    /** Update a task */
    async updateTask(id: number, payload: Partial<Task>) {
      this.loading = true
      this.error = null
      try {
        const response = await api.put(`/tasks/${id}`, payload)
        const index = this.tasks.findIndex(t => t.id === id)
        if (index !== -1) this.tasks[index] = response.data.data
        if (this.task?.id === id) this.task = response.data.data
        return response.data.data
      } catch (err: any) {
        console.error("Error updating task:", err.response?.data)
        this.error = err.response?.data?.message || "Failed to update task"
        throw err
      } finally {
        this.loading = false
      }
    },

    /** Delete a task */
    async deleteTask(id: number) {
      this.loading = true
      this.error = null
      try {
        await api.delete(`/tasks/${id}`)
        this.tasks = this.tasks.filter(t => t.id !== id)
        if (this.task?.id === id) this.task = null
      } catch (err: any) {
        console.error("Error deleting task:", err.response?.data)
        this.error = err.response?.data?.message || "Failed to delete task"
        throw err
      } finally {
        this.loading = false
      }
    },
  },
})
