<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { gsap } from 'gsap'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const isDarkMode = ref(true)
const showPassword = ref(false)
const loginForm = ref(null)
const logoRef = ref(null)

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value
    localStorage.setItem('loginDarkMode', isDarkMode.value)
}

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value
}

onMounted(() => {
    // Load saved theme
    const savedTheme = localStorage.getItem('loginDarkMode')
    if (savedTheme !== null) {
        isDarkMode.value = JSON.parse(savedTheme)
    }

    // Entrance animations
    gsap.from(loginForm.value, {
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    })

    gsap.from(logoRef.value, {
        scale: 0.8,
        opacity: 0,
        duration: 1.2,
        ease: "back.out(1.7)",
        delay: 0.3
    })

    // Add Font Awesome
    const link = document.createElement('link')
    link.rel = 'stylesheet'
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
    document.head.appendChild(link)
})
</script>

<template>
    <Head title="Welcome Back - EMPHXS" />

    <div class="min-h-screen flex items-center justify-center p-4 transition-colors duration-500 relative overflow-hidden" :class="isDarkMode ? 'bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900' : 'bg-gradient-to-br from-blue-50 via-indigo-100 to-purple-50'">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-40 right-40 w-96 h-96 bg-gradient-to-r from-purple-400/15 to-pink-400/15 rounded-full blur-3xl animate-float-delayed"></div>
            <div class="absolute bottom-40 left-40 w-80 h-80 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-float-slow"></div>
        </div>

        <!-- Theme Toggle -->
        <button @click="toggleDarkMode" class="absolute top-6 right-6 p-3 rounded-2xl transition-all duration-300 hover:scale-110 backdrop-blur-sm z-10" :class="isDarkMode ? 'bg-white/10 text-yellow-300 hover:bg-white/20' : 'bg-gray-800/10 text-gray-600 hover:bg-gray-800/20'">
            <svg v-if="isDarkMode" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
            </svg>
            <svg v-else class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
            </svg>
        </button>

        <!-- Login Card -->
        <div ref="loginForm" class="relative w-full max-w-md">
            <!-- Main Card -->
            <div class="relative p-10 rounded-3xl backdrop-blur-2xl shadow-2xl border transition-all duration-500" :class="isDarkMode ? 'bg-white/10 border-white/20 shadow-black/20' : 'bg-white/40 border-white/30 shadow-gray-800/10'">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div ref="logoRef" class="inline-flex items-center justify-center mb-6">
                        <div class="h-16 w-16 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 transform-gpu">
                            <span class="text-white font-bold text-2xl">E</span>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold mb-2 transition-colors duration-500" :class="isDarkMode ? 'text-white' : 'text-gray-800'">
                        Welcome Back
                    </h1>
                    <p class="transition-colors duration-500" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">
                        Sign in to your EMPHXS account
                    </p>
                </div>

                <!-- Status Message -->
                <div v-if="status" class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-2xl backdrop-blur-sm">
                    <p class="text-sm font-medium text-green-400 text-center">{{ status }}</p>
                </div>

                <!-- Login Form -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold mb-3 transition-colors duration-300" :class="isDarkMode ? 'text-gray-300 group-focus-within:text-blue-400' : 'text-gray-700 group-focus-within:text-blue-600'">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 transition-colors duration-300" :class="isDarkMode ? 'text-gray-400 group-focus-within:text-blue-400' : 'text-gray-500 group-focus-within:text-blue-600'">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full pl-12 pr-4 py-4 rounded-2xl text-lg font-medium transition-all duration-300 focus:scale-[1.02] transform-gpu"
                                :class="isDarkMode
                                    ? 'bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:bg-white/15 focus:border-blue-400/50 focus:ring-4 focus:ring-blue-400/20'
                                    : 'bg-white/80 border border-gray-200 text-gray-800 placeholder-gray-500 focus:bg-white focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/20'"
                                placeholder="your@email.com"
                            >
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-sm text-red-400 font-medium">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold mb-3 transition-colors duration-300" :class="isDarkMode ? 'text-gray-300 group-focus-within:text-blue-400' : 'text-gray-700 group-focus-within:text-blue-600'">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 transition-colors duration-300" :class="isDarkMode ? 'text-gray-400 group-focus-within:text-blue-400' : 'text-gray-500 group-focus-within:text-blue-600'">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                class="w-full pl-12 pr-16 py-4 rounded-2xl text-lg font-medium transition-all duration-300 focus:scale-[1.02] transform-gpu"
                                :class="isDarkMode
                                    ? 'bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:bg-white/15 focus:border-blue-400/50 focus:ring-4 focus:ring-blue-400/20'
                                    : 'bg-white/80 border border-gray-200 text-gray-800 placeholder-gray-500 focus:bg-white focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/20'"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                @click="togglePasswordVisibility"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 transition-colors duration-300 hover:scale-110"
                                :class="isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-800'"
                            >
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-400 font-medium">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="w-5 h-5 rounded-lg border-2 transition-all duration-300 focus:ring-4 focus:ring-blue-400/20"
                                :class="isDarkMode
                                    ? 'bg-white/10 border-white/20 text-blue-500 focus:border-blue-400'
                                    : 'bg-white border-gray-300 text-blue-600 focus:border-blue-500'"
                            >
                            <span class="ml-3 text-sm font-medium transition-colors duration-300" :class="isDarkMode ? 'text-gray-300 group-hover:text-white' : 'text-gray-600 group-hover:text-gray-800'">
                                Remember me
                            </span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm font-medium transition-all duration-300 hover:scale-105 transform-gpu"
                            :class="isDarkMode ? 'text-blue-400 hover:text-blue-300' : 'text-blue-600 hover:text-blue-500'"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-4 px-6 rounded-2xl font-bold text-lg transition-all duration-500 hover:scale-105 transform-gpu bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-500 disabled:to-gray-600 text-white shadow-2xl hover:shadow-3xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden"
                    >
                        <span v-if="form.processing" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing In...
                        </span>
                        <span v-else>🚀 Sign In</span>
                        <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </button>

                    <!-- Register Link -->
                    <div class="text-center pt-6 border-t transition-colors duration-500" :class="isDarkMode ? 'border-white/20' : 'border-gray-200'">
                        <p class="text-sm transition-colors duration-500" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">
                            Don't have an account?
                            <Link
                                :href="route('register')"
                                class="font-semibold transition-all duration-300 hover:scale-105 transform-gpu inline-block"
                                :class="isDarkMode ? 'text-blue-400 hover:text-blue-300' : 'text-blue-600 hover:text-blue-500'"
                            >
                                Create Account
                            </Link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(1deg); }
    66% { transform: translateY(-10px) rotate(-1deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-15px) rotate(-1deg); }
    66% { transform: translateY(-25px) rotate(1deg); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-30px) rotate(2deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 7s ease-in-out infinite;
    animation-delay: 2s;
}

.animate-float-slow {
    animation: float-slow 8s ease-in-out infinite;
    animation-delay: 1s;
}

/* Transform GPU acceleration */
.transform-gpu {
    transform: translateZ(0);
    backface-visibility: hidden;
    perspective: 1000px;
}

/* Custom shadows */
.shadow-3xl {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Smooth transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
}
</style>