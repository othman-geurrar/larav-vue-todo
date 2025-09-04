import { createRouter, createWebHistory } from 'vue-router'
import AuthInterface from '@/components/auth/AuthInterface.vue'
import Tasks from '@/components/Tasks.vue'
import { useAuthStore } from '@/stores/AuthStore'
import Notification from '@/components/Notification.vue'

const routes = [
  { path: '/', name: 'Auth', component: AuthInterface },
  { path: '/tasks', name: 'Tasks', component: Tasks, meta: { requiresAuth: true } },
  { path: '/notifications', name: 'Notifications', component: Notification, meta: { requiresAuth: true } }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  auth.loadUserFromStorage() // restore from localStorage

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    // protect /tasks if not logged in
    next('/')
  } else if (to.path === '/' && auth.isAuthenticated) {
    // redirect logged-in user away from login page
    next('/tasks')
  } else {
    next()
  }
})

export default router
