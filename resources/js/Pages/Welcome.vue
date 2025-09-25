<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

const isDarkMode = ref(false)
const currentSlide = ref(0)
const currentPortfolioSlide = ref(0)

// Company stats
const stats = ref([
    { value: 0, target: 150, label: "Projects Completed", suffix: "+" },
    { value: 0, target: 99.9, label: "Uptime Guarantee", suffix: "%" },
    { value: 0, target: 8, label: "Years Experience", suffix: "+" },
    { value: 0, target: 24, label: "Hour Support", suffix: "/7" }
])

const services = ref([
    {
        title: "Web Development",
        description: "Custom websites and web applications built with modern technologies",
        icon: "fas fa-code",
        features: ["Custom Website Development", "E-commerce Solutions", "Content Management Systems", "Mobile-Responsive Design"]
    },
    {
        title: "Web Hosting",
        description: "Reliable, fast, and secure hosting solutions with guaranteed uptime",
        icon: "fas fa-server",
        features: ["Shared Hosting Plans", "VPS & Dedicated Servers", "SSL Certificates", "Daily Backups"]
    },
    {
        title: "Digital Solutions",
        description: "Complete digital transformation services for modern businesses",
        icon: "fas fa-digital-tachograph",
        features: ["SEO Optimization", "Digital Marketing", "Business Analytics", "Technical Consulting"]
    },
    {
        title: "Maintenance & Support",
        description: "Ongoing website maintenance and technical support services",
        icon: "fas fa-tools",
        features: ["24/7 Technical Support", "Regular Updates", "Security Monitoring", "Performance Optimization"]
    }
])

// Portfolio projects with detailed information
const portfolioProjects = ref([
    {
        id: 1,
        title: "Malawi Tourism Board Website",
        category: "Government Portal",
        description: "A comprehensive tourism portal showcasing Malawi's attractions, accommodations, and travel information with integrated booking system.",
        technologies: ["Laravel", "Vue.js", "MySQL", "Payment Gateway"],
        features: ["Online Booking", "Multi-language Support", "Mobile App", "Admin Dashboard"],
        results: "300% increase in online bookings, 150% growth in international visitor inquiries",
        duration: "3 months",
        client: "Malawi Tourism Board",
        year: "2024",
        imageUrl: "https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "EMPHXS transformed our online presence completely. The new website has significantly boosted tourism inquiries."
    },
    {
        id: 2,
        title: "Blantyre Business Hub",
        category: "E-commerce Platform",
        description: "Modern e-commerce platform connecting local businesses with customers, featuring vendor management and secure payment processing.",
        technologies: ["React", "Node.js", "MongoDB", "Stripe API"],
        features: ["Multi-vendor Support", "Inventory Management", "Real-time Chat", "Analytics Dashboard"],
        results: "200+ local vendors onboarded, $50K+ monthly transactions processed",
        duration: "4 months",
        client: "Blantyre Chamber of Commerce",
        year: "2024",
        imageUrl: "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "The platform has revolutionized how our local businesses operate online. Excellent work by EMPHXS!"
    },
    {
        id: 3,
        title: "Lilongwe Medical Center",
        category: "Healthcare System",
        description: "Complete healthcare management system with patient portal, appointment scheduling, and telemedicine capabilities.",
        technologies: ["PHP", "Laravel", "PostgreSQL", "WebRTC"],
        features: ["Patient Portal", "Online Appointments", "Telemedicine", "Medical Records"],
        results: "60% reduction in waiting times, 400% increase in appointment bookings",
        duration: "5 months",
        client: "Lilongwe Medical Center",
        year: "2023",
        imageUrl: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "EMPHXS delivered a world-class healthcare system that has improved our patient care significantly."
    },
    {
        id: 4,
        title: "Mzuzu University Portal",
        category: "Educational Platform",
        description: "Comprehensive student information system with course management, online learning, and academic tracking.",
        technologies: ["Django", "Python", "React", "PostgreSQL"],
        features: ["Student Portal", "Course Management", "Online Exams", "Grade Tracking"],
        results: "15,000+ students registered, 95% satisfaction rate, paperless administration",
        duration: "6 months",
        client: "Mzuzu University",
        year: "2023",
        imageUrl: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "The system has modernized our entire academic administration. Outstanding technical expertise."
    },
    {
        id: 5,
        title: "Malawi National Bank Mobile App",
        category: "Financial Technology",
        description: "Secure mobile banking application with advanced features for account management and digital transactions.",
        technologies: ["React Native", "Node.js", "MongoDB", "JWT"],
        features: ["Mobile Banking", "QR Payments", "Loan Applications", "Investment Tracking"],
        results: "100K+ downloads, 85% user retention rate, 40% reduction in branch visits",
        duration: "8 months",
        client: "Confidential Banking Client",
        year: "2023",
        imageUrl: "https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "EMPHXS delivered a banking solution that exceeds international standards."
    },
    {
        id: 6,
        title: "Zomba Agricultural Cooperative",
        category: "Agricultural Platform",
        description: "Digital platform connecting farmers with buyers, featuring crop management, pricing, and logistics coordination.",
        technologies: ["Vue.js", "Laravel", "MySQL", "Google Maps API"],
        features: ["Crop Management", "Market Pricing", "Logistics Tracking", "Weather Updates"],
        results: "500+ farmers registered, 25% increase in crop prices, reduced post-harvest losses",
        duration: "3 months",
        client: "Zomba Agricultural Cooperative",
        year: "2024",
        imageUrl: "https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "The platform has transformed how we connect with markets. Farmers are earning 25% more."
    },
    {
        id: 7,
        title: "Malawi Stock Exchange Portal",
        category: "Financial Platform",
        description: "Real-time stock trading platform with advanced analytics, portfolio management, and investor tools.",
        technologies: ["Angular", "Java Spring", "MySQL", "WebSocket"],
        features: ["Real-time Trading", "Portfolio Analytics", "Market News", "Investment Tools"],
        results: "300% increase in online trades, 50+ new institutional investors onboarded",
        duration: "7 months",
        client: "Malawi Stock Exchange",
        year: "2023",
        imageUrl: "https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "EMPHXS delivered a trading platform that rivals international exchanges."
    },
    {
        id: 8,
        title: "Karonga Mining Company",
        category: "Industrial System",
        description: "Comprehensive mining operations management system with equipment tracking, safety monitoring, and production analytics.",
        technologies: ["Python", "Django", "PostgreSQL", "IoT Sensors"],
        features: ["Equipment Tracking", "Safety Monitoring", "Production Analytics", "Compliance Reporting"],
        results: "30% improvement in operational efficiency, zero safety incidents recorded",
        duration: "9 months",
        client: "Karonga Mining Company",
        year: "2022",
        imageUrl: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&crop=center",
        liveUrl: "#",
        testimonial: "The system has revolutionized our mining operations. Safety and efficiency have improved dramatically."
    }
])

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value
    localStorage.setItem('darkMode', JSON.stringify(isDarkMode.value))
}

const scrollTo = (elementId) => {
    const element = document.getElementById(elementId)
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' })
    }
}

const nextPortfolioSlide = () => {
    currentPortfolioSlide.value = (currentPortfolioSlide.value + 1) % portfolioProjects.value.length
}

const previousPortfolioSlide = () => {
    currentPortfolioSlide.value = currentPortfolioSlide.value === 0 ? portfolioProjects.value.length - 1 : currentPortfolioSlide.value - 1
}

const goToPortfolioSlide = (index) => {
    currentPortfolioSlide.value = index
}

const animateCounters = () => {
    stats.value.forEach((stat, index) => {
        gsap.to(stat, {
            value: stat.target,
            duration: 2,
            delay: index * 0.3,
            ease: "power2.out",
            onUpdate: function() {
                if (stat.target === 99.9) {
                    stat.value = Math.round(this.targets()[0].value * 10) / 10
                } else {
                    stat.value = Math.round(this.targets()[0].value)
                }
            }
        })
    })
}

onMounted(() => {
    // Load saved theme
    const savedTheme = localStorage.getItem('darkMode')
    if (savedTheme !== null) {
        isDarkMode.value = JSON.parse(savedTheme)
    }

    // Professional entrance animations
    gsap.fromTo('.hero-content', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        ease: "power2.out"
    })

    // Scroll animations
    gsap.utils.toArray('.fade-in').forEach(element => {
        gsap.fromTo(element, {
            y: 40,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: element,
                start: "top 85%"
            }
        })
    })

    // Stats animation
    ScrollTrigger.create({
        trigger: '.stats-section',
        start: "top 80%",
        onEnter: animateCounters
    })

    // Hero slider auto-advance
    setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % 3
    }, 5000)
})
</script>

<template>
    <Head title="EMPHXS - Professional Web Development & Hosting Solutions in Malawi" />

    <div class="min-h-screen bg-gray-50 transition-colors duration-300" :class="isDarkMode ? 'dark bg-gray-900' : 'bg-gray-50'">
        <!-- Professional Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50" :class="isDarkMode ? 'bg-gray-800 border-b border-gray-700' : 'bg-white shadow-sm'">
            <div class="max-w-7xl mx-auto">
                <!-- Top Contact Bar -->
                <div class="border-b py-2 px-4 sm:px-6 lg:px-8" :class="isDarkMode ? 'border-gray-700 bg-gray-900' : 'border-gray-200 bg-gray-50'">
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center space-x-6">
                            <span class="flex items-center" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                hello@emphxs.com
                            </span>
                            <span class="flex items-center" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                <i class="fas fa-phone mr-2 text-blue-600"></i>
                                +265 XXX XXX XXX
                            </span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-100 transition-colors" :class="isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-600 hover:bg-gray-100'">
                                <i v-if="isDarkMode" class="fas fa-sun"></i>
                                <i v-else class="fas fa-moon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Navigation -->
                <nav class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <div class="bg-blue-600 text-white w-12 h-12 rounded flex items-center justify-center font-bold text-xl mr-3">
                                E
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-900'">EMPHXS</h1>
                                <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Web Development & Hosting</p>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden lg:flex items-center space-x-8">
                            <a @click.prevent="scrollTo('home')" href="#home" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Home</a>
                            <a @click.prevent="scrollTo('services')" href="#services" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Services</a>
                            <a @click.prevent="scrollTo('about')" href="#about" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">About</a>
                            <a @click.prevent="scrollTo('portfolio')" href="#portfolio" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Portfolio</a>
                            <a @click.prevent="scrollTo('contact')" href="#contact" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Contact</a>
                        </div>

                        <!-- CTA Button -->
                        <div class="flex items-center space-x-4">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium transition-colors">
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="font-medium hover:text-blue-600 transition-colors" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Login
                                </Link>
                                <Link v-if="canRegister" :href="route('register')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium transition-colors">
                                    Get Started
                                </Link>
                            </template>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="home" class="relative py-16 lg:py-24" :class="isDarkMode ? 'bg-gray-900' : 'bg-white'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Hero Content -->
                    <div class="hero-content">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight" :class="isDarkMode ? 'text-white' : 'text-gray-900'">
                            Professional Web Development & Hosting Solutions
                        </h1>
                        <p class="text-xl lg:text-2xl mb-8 leading-relaxed" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                            Empowering businesses across Malawi with reliable web development, hosting, and digital solutions that drive growth and success.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-12">
                            <button @click="scrollTo('contact')" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                                Start Your Project
                            </button>
                            <button @click="scrollTo('services')" class="border-2 border-gray-300 hover:border-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors" :class="isDarkMode ? 'text-gray-300 border-gray-600 hover:border-blue-400' : 'text-gray-700 border-gray-300 hover:border-blue-600'">
                                View Services
                            </button>
                        </div>

                        <!-- Company Stats -->
                        <div class="stats-section grid grid-cols-2 lg:grid-cols-4 gap-6">
                            <div v-for="(stat, index) in stats" :key="index" class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ stat.value }}{{ stat.suffix }}</div>
                                <div class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">{{ stat.label }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Image/Slider -->
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg p-1">
                            <div class="rounded-lg p-8 h-80 flex items-center justify-center" :class="isDarkMode ? 'bg-gray-800' : 'bg-white'">
                                <div class="text-center">
                                    <div v-if="currentSlide === 0" class="slide-content">
                                        <i class="fas fa-code text-6xl text-blue-600 mb-4"></i>
                                        <h3 class="text-2xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Web Development</h3>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Custom websites built with modern technologies</p>
                                    </div>
                                    <div v-if="currentSlide === 1" class="slide-content">
                                        <i class="fas fa-server text-6xl text-green-600 mb-4"></i>
                                        <h3 class="text-2xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Web Hosting</h3>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Reliable hosting with 99.9% uptime guarantee</p>
                                    </div>
                                    <div v-if="currentSlide === 2" class="slide-content">
                                        <i class="fas fa-digital-tachograph text-6xl text-purple-600 mb-4"></i>
                                        <h3 class="text-2xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Digital Solutions</h3>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Complete digital transformation for your business</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-16 lg:py-24 fade-in" :class="isDarkMode ? 'bg-gray-800' : 'bg-gray-50'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Our Professional Services</h2>
                    <p class="text-xl max-w-3xl mx-auto" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                        Comprehensive digital solutions designed to help your business succeed in today's competitive market.
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="(service, index) in services" :key="index"
                         class="p-6 rounded-lg border hover:shadow-lg transition-all duration-300"
                         :class="isDarkMode ? 'bg-gray-900 border-gray-700 hover:bg-gray-800' : 'bg-white border-gray-200 hover:shadow-lg'">

                        <!-- Service Icon -->
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4" :class="isDarkMode ? 'bg-gray-800' : 'bg-blue-100'">
                            <i :class="service.icon" class="text-2xl text-blue-600"></i>
                        </div>

                        <!-- Service Content -->
                        <h3 class="text-xl font-bold mb-3" :class="isDarkMode ? 'text-white' : 'text-gray-900'">{{ service.title }}</h3>
                        <p class="mb-4" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">{{ service.description }}</p>

                        <!-- Service Features -->
                        <ul class="space-y-2">
                            <li v-for="feature in service.features" :key="feature" class="text-sm flex items-center" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                {{ feature }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 lg:py-24 fade-in" :class="isDarkMode ? 'bg-gray-900' : 'bg-white'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-bold mb-6" :class="isDarkMode ? 'text-white' : 'text-gray-900'">About EMPHXS</h2>
                        <p class="text-lg mb-6" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                            EMPHXS is Malawi's premier web development and hosting company, committed to delivering exceptional digital solutions that help businesses thrive in the digital age.
                        </p>
                        <p class="text-lg mb-8" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                            With over 8 years of experience and a portfolio of 150+ successful projects, we combine technical expertise with deep understanding of the local market to provide solutions that truly work for Malawi businesses.
                        </p>

                        <!-- Key Points -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mt-1 mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Expert Team</h4>
                                    <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Skilled professionals with proven track record</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mt-1 mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Local Understanding</h4>
                                    <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Deep knowledge of Malawi business environment</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mt-1 mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Reliable Support</h4>
                                    <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">24/7 technical support and maintenance</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mt-1 mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Modern Technology</h4>
                                    <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Latest web technologies and best practices</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 rounded-lg border" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                            <div class="text-3xl font-bold text-blue-600 mb-2">150+</div>
                            <div class="text-sm font-medium" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Successful Projects</div>
                            <div class="text-xs mt-1" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Delivered on time and budget</div>
                        </div>
                        <div class="p-6 rounded-lg border" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                            <div class="text-3xl font-bold text-blue-600 mb-2">99.9%</div>
                            <div class="text-sm font-medium" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Uptime Guarantee</div>
                            <div class="text-xs mt-1" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Reliable hosting services</div>
                        </div>
                        <div class="p-6 rounded-lg border" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                            <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                            <div class="text-sm font-medium" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Technical Support</div>
                            <div class="text-xs mt-1" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Always here to help</div>
                        </div>
                        <div class="p-6 rounded-lg border" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                            <div class="text-3xl font-bold text-blue-600 mb-2">8+</div>
                            <div class="text-sm font-medium" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Years Experience</div>
                            <div class="text-xs mt-1" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Industry expertise</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Portfolio Section -->
        <section id="portfolio" class="py-16 lg:py-24 fade-in" :class="isDarkMode ? 'bg-gray-800' : 'bg-gray-50'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Our Recent Work</h2>
                    <p class="text-xl max-w-3xl mx-auto" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                        Explore our portfolio of successful projects across various industries in Malawi. Each project showcases our expertise and commitment to delivering exceptional results.
                    </p>
                </div>

                <!-- Portfolio Slider -->
                <div class="relative">
                    <!-- Main Portfolio Display -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-12">
                        <!-- Project Image -->
                        <div class="relative">
                            <div class="rounded-lg overflow-hidden shadow-lg">
                                <img :src="portfolioProjects[currentPortfolioSlide].imageUrl"
                                     :alt="portfolioProjects[currentPortfolioSlide].title"
                                     class="w-full h-80 object-cover transition-all duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <span class="bg-blue-600 px-3 py-1 rounded-full text-sm font-medium">{{ portfolioProjects[currentPortfolioSlide].category }}</span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <a :href="portfolioProjects[currentPortfolioSlide].liveUrl" class="bg-white/20 backdrop-blur-sm text-white p-2 rounded-full hover:bg-white/30 transition-colors">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Project Details -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-2xl lg:text-3xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-900'">
                                        {{ portfolioProjects[currentPortfolioSlide].title }}
                                    </h3>
                                    <span class="text-sm font-medium px-3 py-1 rounded-full" :class="isDarkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'">
                                        {{ portfolioProjects[currentPortfolioSlide].year }}
                                    </span>
                                </div>
                                <p class="text-sm mb-4" :class="isDarkMode ? 'text-blue-400' : 'text-blue-600'">
                                    {{ portfolioProjects[currentPortfolioSlide].client }}
                                </p>
                                <p class="text-lg leading-relaxed" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                    {{ portfolioProjects[currentPortfolioSlide].description }}
                                </p>
                            </div>

                            <!-- Technologies Used -->
                            <div>
                                <h4 class="text-sm font-semibold mb-3 uppercase tracking-wide" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Technologies Used</h4>
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="tech in portfolioProjects[currentPortfolioSlide].technologies" :key="tech"
                                          class="px-3 py-1 rounded-full text-sm font-medium" :class="isDarkMode ? 'bg-gray-700 text-gray-300' : 'bg-blue-100 text-blue-800'">
                                        {{ tech }}
                                    </span>
                                </div>
                            </div>

                            <!-- Key Features -->
                            <div>
                                <h4 class="text-sm font-semibold mb-3 uppercase tracking-wide" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Key Features</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div v-for="feature in portfolioProjects[currentPortfolioSlide].features" :key="feature"
                                         class="flex items-center text-sm" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        {{ feature }}
                                    </div>
                                </div>
                            </div>

                            <!-- Project Results -->
                            <div class="p-4 rounded-lg" :class="isDarkMode ? 'bg-gray-900' : 'bg-green-50'">
                                <h4 class="text-sm font-semibold mb-2 uppercase tracking-wide text-green-600">Project Results</h4>
                                <p class="text-sm font-medium" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">
                                    {{ portfolioProjects[currentPortfolioSlide].results }}
                                </p>
                            </div>

                            <!-- Client Testimonial -->
                            <div class="p-4 rounded-lg border-l-4 border-blue-500" :class="isDarkMode ? 'bg-gray-900' : 'bg-blue-50'">
                                <p class="text-sm italic mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                    "{{ portfolioProjects[currentPortfolioSlide].testimonial }}"
                                </p>
                                <p class="text-xs font-medium" :class="isDarkMode ? 'text-blue-400' : 'text-blue-600'">
                                    - {{ portfolioProjects[currentPortfolioSlide].client }}
                                </p>
                            </div>

                            <!-- Project Stats -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 rounded-lg" :class="isDarkMode ? 'bg-gray-900' : 'bg-white'">
                                    <div class="text-lg font-bold text-blue-600">{{ portfolioProjects[currentPortfolioSlide].duration }}</div>
                                    <div class="text-xs" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Project Duration</div>
                                </div>
                                <div class="text-center p-3 rounded-lg" :class="isDarkMode ? 'bg-gray-900' : 'bg-white'">
                                    <div class="text-lg font-bold text-green-600">Completed</div>
                                    <div class="text-xs" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">Status</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Controls -->
                    <div class="flex items-center justify-between mb-8">
                        <button @click="previousPortfolioSlide"
                                class="flex items-center px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:scale-105"
                                :class="isDarkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-50 shadow-md'">
                            <i class="fas fa-chevron-left mr-2"></i>
                            Previous Project
                        </button>

                        <div class="flex items-center space-x-2">
                            <button v-for="(project, index) in portfolioProjects.slice(0, 5)" :key="project.id"
                                    @click="goToPortfolioSlide(index)"
                                    class="w-3 h-3 rounded-full transition-all duration-300"
                                    :class="currentPortfolioSlide === index ? 'bg-blue-600 scale-125' : (isDarkMode ? 'bg-gray-600 hover:bg-gray-500' : 'bg-gray-300 hover:bg-gray-400')">
                            </button>
                            <span v-if="portfolioProjects.length > 5" class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-500'">
                                +{{ portfolioProjects.length - 5 }} more
                            </span>
                        </div>

                        <button @click="nextPortfolioSlide"
                                class="flex items-center px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:scale-105"
                                :class="isDarkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-50 shadow-md'">
                            Next Project
                            <i class="fas fa-chevron-right ml-2"></i>
                        </button>
                    </div>

                    <!-- Portfolio Grid Preview -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                        <div v-for="(project, index) in portfolioProjects" :key="project.id"
                             @click="goToPortfolioSlide(index)"
                             class="cursor-pointer group relative overflow-hidden rounded-lg aspect-[4/3] transition-all duration-300"
                             :class="currentPortfolioSlide === index ? 'ring-2 ring-blue-500 scale-105' : 'hover:scale-105 opacity-70 hover:opacity-100'">
                            <img :src="project.imageUrl" :alt="project.title" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                    <i class="fas fa-eye text-white"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-1 left-1 right-1">
                                <p class="text-white text-xs font-medium truncate">{{ project.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 lg:py-24 fade-in" :class="isDarkMode ? 'bg-gray-900' : 'bg-white'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Get In Touch</h2>
                    <p class="text-xl max-w-3xl mx-auto" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                        Ready to start your project? Contact us today for a free consultation and let's discuss how we can help your business grow.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div class="p-8 rounded-lg border" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                        <h3 class="text-2xl font-bold mb-6" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Send us a Message</h3>

                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">First Name</label>
                                    <input type="text" class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300'">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Last Name</label>
                                    <input type="text" class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300'">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Email Address</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300'">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Service Required</label>
                                <select class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300'">
                                    <option>Web Development</option>
                                    <option>Web Hosting</option>
                                    <option>Digital Solutions</option>
                                    <option>Maintenance & Support</option>
                                    <option>Consultation</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">Project Details</label>
                                <textarea rows="4" class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300'" placeholder="Tell us about your project requirements..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">
                                Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-2xl font-bold mb-6" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Contact Information</h3>

                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4" :class="isDarkMode ? 'bg-gray-800' : 'bg-blue-100'">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Office Location</h4>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Lilongwe, Malawi</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4" :class="isDarkMode ? 'bg-gray-800' : 'bg-blue-100'">
                                        <i class="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Email Address</h4>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">hello@emphxs.com</p>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">projects@emphxs.com</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4" :class="isDarkMode ? 'bg-gray-800' : 'bg-blue-100'">
                                        <i class="fas fa-phone text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-1" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Phone Number</h4>
                                        <p :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">+265 XXX XXX XXX</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-900'">Business Hours</h4>
                            <div class="space-y-2 text-sm" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">
                                <div class="flex justify-between">
                                    <span>Monday - Friday:</span>
                                    <span>8:00 AM - 6:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Saturday:</span>
                                    <span>9:00 AM - 4:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Sunday:</span>
                                    <span>Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 border-t" :class="isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-900 border-gray-300'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-600 text-white w-10 h-10 rounded flex items-center justify-center font-bold text-lg mr-3">
                                E
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">EMPHXS</h3>
                                <p class="text-sm text-gray-400">Web Development & Hosting</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-6 max-w-md">
                            Malawi's leading web development and hosting company, providing professional digital solutions for businesses of all sizes.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-blue-600 rounded flex items-center justify-center text-white transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-blue-600 rounded flex items-center justify-center text-white transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-blue-600 rounded flex items-center justify-center text-white transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Services -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Services</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><a href="#" class="hover:text-white transition-colors">Web Development</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Web Hosting</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Digital Solutions</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Technical Support</a></li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Company</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Our Team</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-400">
                        © {{ new Date().getFullYear() }} EMPHXS. All rights reserved. Professional Web Development & Hosting Solutions in Malawi.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

/* Professional fade-in animation */
.fade-in {
    opacity: 0;
    transform: translateY(20px);
}

/* Smooth transitions */
* {
    transition-property: background-color, border-color, color, opacity, transform;
    transition-duration: 300ms;
    transition-timing-function: ease;
}

/* Slide content animation */
.slide-content {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Professional hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Form focus states */
input:focus, textarea:focus, select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
}
</style>