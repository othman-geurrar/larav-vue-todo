<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-teal-600">TodoApp</h1>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex items-center space-x-4">
            <!-- Notifications Button -->
            <button
              @click="router.push('/notifications')"
              class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition-colors duration-200 relative"
              title="Notifications"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
              </svg>
            </button>
            
            <button
              @click="showAddTaskModal = true"
              class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              <span>Add Task</span>
            </button>
            <button
              @click="logout"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Empty State -->
      <div v-if="userTasks.length === 0" class="text-center py-12">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No tasks yet</h3>
        <p class="text-gray-500 mb-6">Get started by creating your first task</p>
        <button
          @click="showAddTaskModal = true"
          class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200"
        >
          Create Your First Task
        </button>
      </div>

      <!-- Tasks List -->
      <div v-else class="space-y-4">
        <div
          v-for="task in userTasks"
          :key="task.id"
          class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200"
        >
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center space-x-3 mb-2">
                <!-- Status Symbol -->
                <div class="flex-shrink-0">
                  <svg
                    v-if="task.is_done"
                    class="w-6 h-6 text-green-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <svg
                    v-else
                    class="w-6 h-6 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                  </svg>
                </div>
                
                <!-- Task Name -->
                <h3 class="text-lg font-semibold text-gray-900" :class="{ 'line-through text-gray-500': task.is_done }">
                  {{ task.name }}
                </h3>
              </div>
              
              <!-- Task Description -->
              <p class="text-gray-600 mb-3" :class="{ 'line-through': task.is_done }">
                {{ task.description }}
              </p>
              
              <!-- Deadline -->
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Due: {{ formatDate(task.deadline ?? '') }}</span>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 ml-4">
              <button
                @click="typeof task.id === 'number' && toggleTaskStatus(task.id)"
                :class="task.is_done 
                  ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' 
                  : 'bg-green-100 hover:bg-green-200 text-green-700'"
                class="px-3 py-2 rounded-lg font-medium transition-colors duration-200 text-sm"
              >
                {{ task.is_done ? 'Undo' : 'Done' }}
              </button>
              <button
                @click="openEditTaskModal(task)"
                class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg font-medium transition-colors duration-200 text-sm"
              >
                Edit
              </button>
              <button
                @click="typeof task.id === 'number' && deleteTask(task.id)"
                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg font-medium transition-colors duration-200 text-sm"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Add Task Modal -->
    <div v-if="showAddTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Add New Task</h2>
        
        <form @submit.prevent="addTask" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Task Name</label>
            <input
              v-model="newTask.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none"
              placeholder="Enter task name"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="newTask.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none resize-none"
              placeholder="Enter task description"
            ></textarea>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
            <input
              v-model="newTask.deadline"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none"
            >
          </div>
          
          <div class="flex justify-end space-x-3 pt-4">
            <button
              type="button"
              @click="closeAddTaskModal"
              class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium transition-colors duration-200"
            >
              Add Task
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Task Modal -->
    <div v-if="showEditTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Task</h2>
        <form @submit.prevent="editTask" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Task Name</label>
            <input
              v-model="editTaskData.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              placeholder="Enter task name"
            >
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="editTaskData.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"
              placeholder="Enter task description"
            ></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
            <input
              v-model="editTaskData.deadline"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
            >
          </div>
          <div class="flex justify-end space-x-3 pt-4">
            <button
              type="button"
              @click="closeEditTaskModal"
              class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200"
            >
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, reactive, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/AuthStore'
import { useTaskStore, type Task } from '@/stores/TaskStore'

const auth = useAuthStore()
const taskStore = useTaskStore()
const router = useRouter()

// Redirect if not authenticated
if (!auth.isAuthenticated) {
  router.push('/')
}

// State
const showAddTaskModal = ref(false)
const showEditTaskModal = ref(false)
const tasks = ref<Task[]>([])

// Computed property to filter tasks by current user
const userTasks = computed(() => {
  return tasks.value.filter(task => task.user_id === auth.user?.id)
})
const newTask = reactive({
  name: '',
  description: '',
  deadline: ''
})
const editTaskData = reactive({
  id: null as number | null,
  name: '',
  description: '',
  deadline: ''
})
const openEditTaskModal = (task:Task) => {
  editTaskData.id = task.id || null
  editTaskData.name = task.name
  editTaskData.description = task.description || ''
  
  // Convert the deadline to YYYY-MM-DD
  const date = new Date(task.deadline || '')
  editTaskData.deadline = date.toISOString().split('T')[0] // "2025-09-04"

  showEditTaskModal.value = true
}


const closeEditTaskModal = () => {
  showEditTaskModal.value = false
  editTaskData.id = null
  editTaskData.name = ''
  editTaskData.description = ''
  editTaskData.deadline = ''
}

const editTask = async () => {
  if (editTaskData.id && editTaskData.name && editTaskData.deadline) {
    try {
      await taskStore.updateTask(editTaskData.id, {
        name: editTaskData.name,
        description: editTaskData.description,
        deadline: editTaskData.deadline
      })
      await taskStore.fetchTasks()
      tasks.value = taskStore.tasks
      closeEditTaskModal()
    } catch (err) {
      console.error('Error editing task:', err)
    }
  }
}

// Fetch tasks on mount
onMounted(async () => {
  try {
    await taskStore.fetchTasks()
    tasks.value = taskStore.tasks
  } catch (err) {
    console.error('Error loading tasks:', err)
  }
})

// Methods
const addTask = async () => {
  if (newTask.name && newTask.deadline) {
    try {
      await taskStore.createTask({
        name: newTask.name,
        description: newTask.description,
        deadline: newTask.deadline,
        user_id: auth.user.id,  // assign logged-in user
        is_done: false
      })
      await taskStore.fetchTasks()
      tasks.value = taskStore.tasks
      closeAddTaskModal()
    } catch (err) {
      console.error('Error adding task:', err)
    }
  }
}

const closeAddTaskModal = () => {
  showAddTaskModal.value = false
  newTask.name = ''
  newTask.description = ''
  newTask.deadline = ''
}

const toggleTaskStatus = async (taskId: number) => {
  const task = userTasks.value.find(t => t.id === taskId)
  if (!task) return

  try {
    const updatedTask = await taskStore.updateTask(taskId, { is_done: !task.is_done })
    task.is_done = updatedTask.is_done
  } catch (err) {
    console.error('Error toggling task status:', err)
  }
}

const deleteTask = async (taskId: number) => {
  try {
    await taskStore.deleteTask(taskId)
    tasks.value = tasks.value.filter(t => t.id !== taskId)
  } catch (err) {
    console.error('Error deleting task:', err)
  }
}

const logout = async () => {
  await auth.logout()
  router.push('/')
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric' 
  })
}
</script>