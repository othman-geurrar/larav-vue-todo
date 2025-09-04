<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-4xl w-full h-[600px] relative">
      <!-- Decorative elements -->
      <div class="absolute top-0 right-0 w-32 h-32 bg-red-400 rounded-bl-full"></div>
      <div class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-400 rounded-tr-full"></div>
      
      <div class="flex h-full relative">
        <!-- Left Panel -->
        <div 
          class="w-1/2 flex flex-col justify-center items-center p-12 transition-all duration-700 ease-in-out"
          :class="isSignIn ? 'bg-white' : 'bg-gradient-to-br from-teal-400 to-teal-600'"
        >
          <!-- Logo (always visible) -->
          <div class="absolute top-6 left-6">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-white bg-opacity-20 rounded flex items-center justify-center">
                <span class="text-white text-xs font-bold">D</span>
              </div>
              <span class="text-white font-semibold">Diprella</span>
            </div>
          </div>

          <!-- Sign Up Mode (Left Panel) -->
          <div v-if="!isSignIn" class="text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Welcome Back!</h2>
            <p class="text-lg mb-8 opacity-90">
              To keep connected with us please<br>
              login with your personal info
            </p>
            <button 
              @click="toggleMode"
              class="border-2 border-white text-white px-12 py-3 rounded-full font-semibold hover:bg-white hover:text-teal-500 transition-all duration-300"
            >
              SIGN IN
            </button>
          </div>

          <!-- Sign In Form (Left Panel) -->
          <div v-else class="w-full max-w-sm">
            <h2 class="text-3xl font-bold text-teal-500 text-center mb-8">Sign in to Diprella</h2>
            
            <!-- Social Login Buttons -->
            <div class="flex justify-center space-x-4 mb-6">
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-blue-600 font-bold">f</span>
              </button>
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-red-500 font-bold">G+</span>
              </button>
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-blue-700 font-bold">in</span>
              </button>
            </div>

            <p class="text-gray-500 text-center mb-6">or use your email account:</p>

            <!-- Sign In Form -->
            <form @submit.prevent="handleSignIn" class="space-y-4">
              <div class="relative">
                <input
                  v-model="signInForm.email"
                  type="email"
                  placeholder="Email"
                  class="w-full px-4 py-3 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">✉</span>
              </div>
              
              <div class="relative">
                <input
                  v-model="signInForm.password"
                  type="password"
                  placeholder="Password"
                  class="w-full px-4 py-3 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔒</span>
              </div>


              <button
                type="submit"
                class="w-full bg-teal-500 text-white py-3 rounded-full font-semibold hover:bg-teal-600 transition-colors"
              >
                SIGN IN
              </button>
            </form>
          </div>
        </div>

        <!-- Right Panel -->
        <div 
          class="w-1/2 flex flex-col justify-center items-center p-12 transition-all duration-700 ease-in-out overflow-y-auto"
          :class="isSignIn ? 'bg-gradient-to-br from-teal-400 to-teal-600' : 'bg-white'"
        >
          <!-- Sign Up Form (Right Panel) -->
          <div v-if="!isSignIn" class="w-full max-w-sm">
            <h2 class="text-3xl font-bold text-teal-500 text-center mb-8">Create Account</h2>
            
            <!-- Social Login Buttons -->
            <div class="flex justify-center space-x-4 mb-4">
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-blue-600 font-bold">f</span>
              </button>
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-red-500 font-bold">G+</span>
              </button>
              <button class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                <span class="text-blue-700 font-bold">in</span>
              </button>
            </div>

            <p class="text-gray-500 text-center mb-4 text-sm">or use your email for registration:</p>

            <!-- Updated sign up form with additional fields -->
            <form @submit.prevent="handleSignUp" class="space-y-3">
              <div class="relative">
                <input
                  v-model="signUpForm.full_name"
                  type="text"
                  placeholder="Full Name"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">👤</span>
              </div>
              
              <div class="relative">
                <input
                  v-model="signUpForm.email"
                  type="email"
                  placeholder="Email"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">✉</span>
              </div>
              
              <div class="relative">
                <input
                  v-model="signUpForm.password"
                  type="password"
                  placeholder="Password"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔒</span>
              </div>
              <div class="relative">
                <input
                  v-model="signUpForm.password_confirmation"
                  type="password"
                  placeholder="Confirm Password"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔒</span>
              </div>

              <div class="relative">
                <input
                  v-model="signUpForm.phone_number"
                  type="tel"
                  placeholder="Phone Number"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">📞</span>
              </div>

              <div class="relative">
                <input
                  v-model="signUpForm.address"
                  type="text"
                  placeholder="Address"
                  class="w-full px-4 py-2.5 pl-10 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                  required
                />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🏠</span>
              </div>

              <button
                type="submit"
                class="w-full bg-teal-500 text-white py-2.5 rounded-full font-semibold hover:bg-teal-600 transition-colors text-sm mt-4"
              >
                SIGN UP
              </button>
            </form>
          </div>

          <!-- Sign In Mode (Right Panel) -->
          <div v-else class="text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Hello, Friend!</h2>
            <p class="text-lg mb-8 opacity-90">
              Enter your personal details<br>
              and start journey with us
            </p>
            <button 
              @click="toggleMode"
              class="border-2 border-white text-white px-12 py-3 rounded-full font-semibold hover:bg-white hover:text-teal-500 transition-all duration-300"
            >
              SIGN UP
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore'
import { ref } from 'vue'
import { useRouter } from 'vue-router'


const auth = useAuthStore()
const router = useRouter()

const isSignIn = ref(false)

// Updated signUpForm to include all required fields
const signUpForm = ref({
  full_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  phone_number: '',
  address: ''
})

const signInForm = ref({
  email: '',
  password: ''
})

const toggleMode = () => {
  isSignIn.value = !isSignIn.value
}

const handleSignUp = async() => {
  console.log('Sign up:', signUpForm.value)
  // Handle sign up logic here
    try {
      await auth.register(signUpForm.value)
      alert("Registered successfully ✅")
      toggleMode()
    } catch (err) {
      alert(auth.error || "Registration failed ❌")
    }
   
}

const handleSignIn = async() => {
  console.log('Sign in:', signInForm.value)
  // Handle sign in logic here
  try {
    await auth.login(signInForm.value)
    alert("Logged in successfully ✅")
    // Redirect or perform post-login actions here

    if (auth.isAuthenticated) {
      router.push('/tasks')
    }
  } catch (err) {
    alert(auth.error || "Login failed ❌")
    console.error(err)

  }
}
</script>