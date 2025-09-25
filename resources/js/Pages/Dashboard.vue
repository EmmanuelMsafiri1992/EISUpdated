<template>
    <Head title="Dashboard - EMPHXS Admin" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 flex">

        <!-- Professional Sidebar -->
        <div class="flex-shrink-0 transition-all duration-300" :class="sidebarCollapsed ? 'w-16' : 'w-64'">
            <div class="h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-lg">

                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <div v-show="!sidebarCollapsed" class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">E</span>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 dark:text-white">EMPHXS</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
                        </div>
                    </div>
                    <button @click="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sidebarCollapsed ? 'M13 5l7 7-7 7M5 5l7 7-7 7' : 'M11 19l-7-7 7-7M19 19l-7-7 7-7'"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-2">
                    <div v-for="item in navigationItems" :key="item.key" class="group">
                        <button @click="setActiveSection(item.key)" class="w-full flex items-center px-3 py-3 text-left rounded-xl transition-all duration-300 group" :class="activeSection === item.key ? 'bg-blue-500 text-white shadow-lg transform scale-105' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'">
                            <i :class="[item.icon, 'text-lg', sidebarCollapsed ? 'mx-auto' : 'mr-3']"></i>
                            <span v-show="!sidebarCollapsed" class="font-medium">{{ item.label }}</span>
                            <span v-if="item.badge && !sidebarCollapsed" class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ item.badge }}</span>
                        </button>
                    </div>
                </nav>

                <!-- User Profile Section -->
                <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="flex items-center space-x-3" v-show="!sidebarCollapsed">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center text-white font-bold">
                            {{ $page.props.auth.user.name.charAt(0) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $page.props.auth.user.email }}</p>
                        </div>
                        <button @click="logout" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300" title="Logout">
                            <i class="fas fa-sign-out-alt text-gray-500 dark:text-gray-400"></i>
                        </button>
                    </div>
                    <div v-show="sidebarCollapsed" class="flex justify-center">
                        <button @click="logout" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300" title="Logout">
                            <i class="fas fa-sign-out-alt text-gray-500 dark:text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header Bar -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ getCurrentSectionTitle() }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Welcome back, {{ $page.props.auth.user.name }}!
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Theme Toggle -->
                        <button @click="toggleDarkMode" class="p-2 rounded-xl transition-all duration-300 hover:scale-110" :class="isDarkMode ? 'bg-gray-700 text-yellow-400 hover:bg-gray-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                            <svg v-if="isDarkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                            </svg>
                            <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                            </svg>
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-xl transition-all duration-300 hover:scale-110" :class="isDarkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM3 17V7a4 4 0 118 0v10a4 4 0 01-8 0z"/>
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ notifications.length }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-y-auto p-6">

                <!-- Dashboard Overview -->
                <div v-if="activeSection === 'dashboard'" class="space-y-6">
                    <!-- Quick Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div v-for="(stat, index) in stats" :key="index" class="group relative p-6 rounded-2xl transition-all duration-300 hover:scale-105 cursor-pointer" :class="isDarkMode ? 'bg-gray-800 hover:bg-gray-750' : 'bg-white hover:shadow-xl'" @click="navigateToSection(stat.section)">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ stat.value }}</h3>
                                    <p class="text-sm font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ stat.label }}</p>
                                    <div class="flex items-center mt-2" :class="stat.trend > 0 ? 'text-green-500' : 'text-red-500'">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="stat.trend > 0 ? 'M7 17l9.2-9.2M17 17V7H7' : 'M17 7l-9.2 9.2M7 7v10h10'"/>
                                        </svg>
                                        <span class="text-sm font-medium">{{ Math.abs(stat.trend) }}% this month</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl" :style="{ backgroundColor: stat.color + '20' }">
                                    <i :class="stat.icon" class="text-2xl" :style="{ color: stat.color }"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Analytics Chart -->
                            <div class="rounded-2xl p-6 transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Website Analytics</h2>
                                    <select class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-300" :class="isDarkMode ? 'bg-gray-700 text-gray-300 border-gray-600' : 'bg-gray-50 text-gray-700 border-gray-300'">
                                        <option>Last 7 days</option>
                                        <option>Last 30 days</option>
                                        <option>Last 3 months</option>
                                    </select>
                                </div>
                                <div class="h-48 flex items-center justify-center rounded-lg" :class="isDarkMode ? 'bg-gray-900' : 'bg-gray-50'">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">📊</div>
                                        <p class="font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Analytics Chart</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Quotes -->
                            <div class="rounded-2xl p-6 transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Recent Quotes</h2>
                                    <button @click="setActiveSection('quotes')" class="text-blue-500 hover:text-blue-600 font-medium text-sm transition-colors duration-300">
                                        View All →
                                    </button>
                                </div>
                                <div class="space-y-3">
                                    <div v-for="(quote, index) in recentQuotes.slice(0,3)" :key="index" class="flex items-center justify-between p-3 rounded-xl transition-all duration-300 cursor-pointer" :class="isDarkMode ? 'bg-gray-700 hover:bg-gray-600' : 'bg-gray-50 hover:bg-gray-100'">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                                {{ quote.name.charAt(0) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-sm" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ quote.name }}</h4>
                                                <p class="text-xs" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ quote.service }}</p>
                                            </div>
                                        </div>
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium" :class="getStatusColor(quote.status)">
                                            {{ quote.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">

                            <!-- Quick Actions -->
                            <div class="rounded-2xl p-6 transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                                <h2 class="text-xl font-bold mb-6" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Quick Actions</h2>
                                <div class="grid grid-cols-2 gap-3">
                                    <button v-for="(action, index) in quickActions" :key="index" @click="handleQuickAction(action.action)" class="p-3 rounded-xl text-center transition-all duration-300 hover:scale-105 group" :class="isDarkMode ? 'bg-gray-700 hover:bg-gray-600 text-white' : 'bg-gray-50 hover:bg-gray-100 text-gray-800'">
                                        <div class="text-xl mb-2 group-hover:scale-110 transition-transform duration-300">{{ action.icon }}</div>
                                        <p class="font-medium text-xs">{{ action.label }}</p>
                                    </button>
                                </div>
                            </div>

                            <!-- Recent Messages -->
                            <div class="rounded-2xl p-6 transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Recent Messages</h2>
                                    <button @click="setActiveSection('chat')" class="text-blue-500 hover:text-blue-600 font-medium text-sm transition-colors duration-300">
                                        View All →
                                    </button>
                                </div>
                                <div class="space-y-3">
                                    <div v-for="(message, index) in recentMessages.slice(0,3)" :key="index" class="flex items-start space-x-3 p-3 rounded-xl transition-all duration-300 cursor-pointer" :class="isDarkMode ? 'bg-gray-700 hover:bg-gray-600' : 'bg-gray-50 hover:bg-gray-100'">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                            {{ message.sender.charAt(0) }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-sm" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ message.sender }}</p>
                                            <p class="text-xs truncate" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ message.message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Status -->
                            <div class="rounded-2xl p-6 transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                                <h2 class="text-xl font-bold mb-6" :class="isDarkMode ? 'text-white' : 'text-gray-800'">System Status</h2>
                                <div class="space-y-3">
                                    <div v-for="(status, index) in websiteStatus" :key="index" class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 rounded-full" :class="status.status === 'online' ? 'bg-green-500' : 'bg-red-500'"></div>
                                            <p class="font-medium text-sm" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">{{ status.service }}</p>
                                        </div>
                                        <span class="text-xs font-medium" :class="status.status === 'online' ? 'text-green-500' : 'text-red-500'">
                                            {{ status.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Management -->
                <div v-else-if="activeSection === 'services'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Manage Services</h3>
                            <button class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl font-medium hover:scale-105 transition-transform duration-300">
                                + Add Service
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="service in managedServices" :key="service.id" class="p-6 rounded-xl border-2 border-dashed transition-all duration-300 hover:border-solid cursor-pointer" :class="isDarkMode ? 'border-gray-600 hover:border-blue-500 bg-gray-700' : 'border-gray-300 hover:border-blue-500 bg-gray-50'">
                                <div class="text-center">
                                    <div class="text-3xl mb-3">{{ service.icon }}</div>
                                    <h4 class="font-bold mb-2" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ service.name }}</h4>
                                    <p class="text-sm mb-4" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ service.description }}</p>
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="p-2 rounded-lg text-blue-500 hover:bg-blue-500/10 transition-colors duration-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-2 rounded-lg text-red-500 hover:bg-red-500/10 transition-colors duration-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Management -->
                <div v-else-if="activeSection === 'portfolio'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Portfolio Projects</h3>
                            <button class="px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-xl font-medium hover:scale-105 transition-transform duration-300">
                                + Add Project
                            </button>
                        </div>
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">💼</div>
                            <p class="text-lg font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Portfolio management interface</p>
                            <p class="text-sm" :class="isDarkMode ? 'text-gray-500' : 'text-gray-500'">Add, edit, and organize your project showcase</p>
                        </div>
                    </div>
                </div>

                <!-- Team Management -->
                <div v-else-if="activeSection === 'team'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Team Members</h3>
                            <button class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-medium hover:scale-105 transition-transform duration-300">
                                + Add Member
                            </button>
                        </div>
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">👥</div>
                            <p class="text-lg font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Team management interface</p>
                            <p class="text-sm" :class="isDarkMode ? 'text-gray-500' : 'text-gray-500'">Manage team member profiles and information</p>
                        </div>
                    </div>
                </div>

                <!-- Quote Management -->
                <div v-else-if="activeSection === 'quotes'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <h3 class="text-2xl font-bold mb-8" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Quote Requests Management</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b" :class="isDarkMode ? 'border-gray-700' : 'border-gray-200'">
                                        <th class="text-left py-3 font-semibold" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Client</th>
                                        <th class="text-left py-3 font-semibold" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Service</th>
                                        <th class="text-left py-3 font-semibold" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Budget</th>
                                        <th class="text-left py-3 font-semibold" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Status</th>
                                        <th class="text-left py-3 font-semibold" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="quote in allQuotes" :key="quote.id" class="border-b transition-colors duration-300 hover:bg-gray-50 dark:hover:bg-gray-700" :class="isDarkMode ? 'border-gray-700' : 'border-gray-200'">
                                        <td class="py-4">
                                            <div>
                                                <p class="font-medium" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ quote.name }}</p>
                                                <p class="text-sm" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ quote.email || quote.name.toLowerCase().replace(' ', '') + '@example.com' }}</p>
                                            </div>
                                        </td>
                                        <td class="py-4" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">{{ quote.service }}</td>
                                        <td class="py-4" :class="isDarkMode ? 'text-gray-300' : 'text-gray-700'">{{ quote.budget }}</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium" :class="getStatusColor(quote.status)">
                                                {{ quote.status }}
                                            </span>
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center space-x-2">
                                                <button class="p-2 rounded-lg text-blue-500 hover:bg-blue-500/10 transition-colors duration-300">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="p-2 rounded-lg text-green-500 hover:bg-green-500/10 transition-colors duration-300">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="p-2 rounded-lg text-red-500 hover:bg-red-500/10 transition-colors duration-300">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Chat Management -->
                <div v-else-if="activeSection === 'chat'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <h3 class="text-2xl font-bold mb-8" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Live Chat Management</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="p-6 rounded-xl" :class="isDarkMode ? 'bg-gray-700' : 'bg-gray-50'">
                                <h4 class="font-semibold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Active Conversations</h4>
                                <div class="space-y-3">
                                    <div v-for="chat in activeChats" :key="chat.id" class="flex items-center justify-between p-3 rounded-lg cursor-pointer transition-colors duration-300" :class="isDarkMode ? 'bg-gray-600 hover:bg-gray-500' : 'bg-white hover:bg-gray-100'">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ chat.user.charAt(0) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-sm" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ chat.user }}</p>
                                                <p class="text-xs" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ chat.lastMessage }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            <span class="text-xs" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ chat.time }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 rounded-xl" :class="isDarkMode ? 'bg-gray-700' : 'bg-gray-50'">
                                <h4 class="font-semibold mb-4" :class="isDarkMode ? 'text-white' : 'text-gray-800'">Chat Statistics</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Total Conversations</span>
                                        <span class="font-bold" :class="isDarkMode ? 'text-white' : 'text-gray-800'">127</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Active Now</span>
                                        <span class="font-bold text-green-500">{{ activeChats.length }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'">Avg Response Time</span>
                                        <span class="font-bold text-blue-500">2m 34s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div v-else-if="activeSection === 'analytics'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📊</div>
                            <p class="text-lg font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Analytics Dashboard</p>
                            <p class="text-sm" :class="isDarkMode ? 'text-gray-500' : 'text-gray-500'">Detailed analytics and reporting</p>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div v-else-if="activeSection === 'settings'" class="h-full">
                    <div class="rounded-2xl p-8 h-full transition-all duration-300" :class="isDarkMode ? 'bg-gray-800' : 'bg-white shadow-lg'">
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">⚙️</div>
                            <p class="text-lg font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">System Settings</p>
                            <p class="text-sm" :class="isDarkMode ? 'text-gray-500' : 'text-gray-500'">Configure system preferences</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

// Theme management
const isDarkMode = ref(false)

// Sidebar state
const sidebarCollapsed = ref(false)

// Active section for CMS
const activeSection = ref('dashboard')

// Dashboard data
const notifications = ref([
    { type: 'quote', message: 'New quote request from John Doe' },
    { type: 'chat', message: '3 unread messages' }
])

const navigationItems = ref([
    { key: 'dashboard', label: 'Dashboard', icon: 'fas fa-home' },
    { key: 'services', label: 'Services', icon: 'fas fa-cogs' },
    { key: 'portfolio', label: 'Portfolio', icon: 'fas fa-briefcase' },
    { key: 'team', label: 'Team', icon: 'fas fa-users' },
    { key: 'quotes', label: 'Quotes', icon: 'fas fa-file-invoice', badge: 5 },
    { key: 'chat', label: 'Chat', icon: 'fas fa-comments' },
    { key: 'analytics', label: 'Analytics', icon: 'fas fa-chart-bar' },
    { key: 'settings', label: 'Settings', icon: 'fas fa-cog' }
])

const stats = ref([
    {
        label: 'Total Projects',
        value: '47',
        trend: 12,
        color: '#3B82F6',
        icon: 'fas fa-briefcase',
        section: 'portfolio'
    },
    {
        label: 'Active Clients',
        value: '23',
        trend: 8,
        color: '#10B981',
        icon: 'fas fa-users',
        section: 'quotes'
    },
    {
        label: 'Revenue (MWK)',
        value: '2.4M',
        trend: 15,
        color: '#F59E0B',
        icon: 'fas fa-chart-line',
        section: 'analytics'
    },
    {
        label: 'Website Visits',
        value: '8.2K',
        trend: -3,
        color: '#EF4444',
        icon: 'fas fa-eye',
        section: 'analytics'
    }
])

const recentQuotes = ref([
    {
        name: 'John Mwale',
        service: 'E-commerce Store',
        budget: 'MWK 1.2M - 2M',
        status: 'pending',
        date: '2 hours ago'
    },
    {
        name: 'Sarah Banda',
        service: 'Business Website',
        budget: 'MWK 400K - 600K',
        status: 'approved',
        date: '1 day ago'
    },
    {
        name: 'Mike Tembo',
        service: 'Web Application',
        budget: 'MWK 800K - 1.5M',
        status: 'in-progress',
        date: '3 days ago'
    }
])

const allQuotes = ref([
    ...recentQuotes.value,
    {
        id: 4,
        name: 'Grace Phiri',
        email: 'grace@example.com',
        service: 'Mobile App',
        budget: 'MWK 1.5M+',
        status: 'completed',
        date: '1 week ago'
    },
    {
        id: 5,
        name: 'James Kanyama',
        email: 'james@company.com',
        service: 'Hosting Package',
        budget: 'MWK 200K',
        status: 'rejected',
        date: '2 weeks ago'
    }
])

const recentMessages = ref([
    {
        sender: 'Alice Wonder',
        message: 'Hi, I need help with my website...',
        time: '5 min ago'
    },
    {
        sender: 'Bob Smith',
        message: 'Can you update my product prices?',
        time: '1 hour ago'
    },
    {
        sender: 'Carol Johnson',
        message: 'The contact form is not working',
        time: '2 hours ago'
    }
])

const activeChats = ref([
    {
        id: 1,
        user: 'David Wilson',
        lastMessage: 'Thanks for the quick response!',
        time: '2m ago'
    },
    {
        id: 2,
        user: 'Emma Davis',
        lastMessage: 'I need more information about pricing',
        time: '5m ago'
    },
    {
        id: 3,
        user: 'Frank Miller',
        lastMessage: 'When will my website be ready?',
        time: '12m ago'
    }
])

const quickActions = ref([
    { label: 'Add Project', icon: '💼', action: 'add-project' },
    { label: 'New Service', icon: '⚙️', action: 'add-service' },
    { label: 'View Analytics', icon: '📊', action: 'analytics' },
    { label: 'Chat Support', icon: '💬', action: 'chat' }
])

const websiteStatus = ref([
    { service: 'Website', status: 'online' },
    { service: 'Database', status: 'online' },
    { service: 'Email Service', status: 'online' },
    { service: 'Backup System', status: 'online' }
])

const managedServices = ref([
    {
        id: 1,
        name: 'Website Development',
        description: 'Custom responsive websites',
        icon: '🌐'
    },
    {
        id: 2,
        name: 'E-commerce Solutions',
        description: 'Online stores with payment integration',
        icon: '🛒'
    },
    {
        id: 3,
        name: 'Mobile Applications',
        description: 'iOS and Android app development',
        icon: '📱'
    },
    {
        id: 4,
        name: 'Web Hosting',
        description: 'Reliable hosting with 99.9% uptime',
        icon: '☁️'
    },
    {
        id: 5,
        name: 'Digital Marketing',
        description: 'SEO and online marketing services',
        icon: '📈'
    },
    {
        id: 6,
        name: 'Maintenance & Support',
        description: 'Ongoing website maintenance',
        icon: '🔧'
    }
])

// Methods
const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value
    localStorage.setItem('dashboardDarkMode', isDarkMode.value)
}

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value
    localStorage.setItem('sidebarCollapsed', sidebarCollapsed.value)
}

const setActiveSection = (section) => {
    activeSection.value = section
}

const navigateToSection = (section) => {
    activeSection.value = section
}

const getCurrentSectionTitle = () => {
    const section = navigationItems.value.find(item => item.key === activeSection.value)
    return section ? section.label : 'Dashboard'
}

const handleQuickAction = (action) => {
    switch(action) {
        case 'add-project':
            activeSection.value = 'portfolio'
            break
        case 'add-service':
            activeSection.value = 'services'
            break
        case 'analytics':
            activeSection.value = 'analytics'
            break
        case 'chat':
            activeSection.value = 'chat'
            break
    }
}

const logout = () => {
    router.post(route('logout'))
}

const getStatusColor = (status) => {
    const colors = {
        'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'approved': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'in-progress': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'completed': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        'rejected': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
    }
    return colors[status] || colors['pending']
}

onMounted(() => {
    // Load theme preference
    const savedTheme = localStorage.getItem('dashboardDarkMode')
    if (savedTheme !== null) {
        isDarkMode.value = JSON.parse(savedTheme)
    }

    // Load sidebar state
    const savedSidebar = localStorage.getItem('sidebarCollapsed')
    if (savedSidebar !== null) {
        sidebarCollapsed.value = JSON.parse(savedSidebar)
    }

    // Add Font Awesome
    const link = document.createElement('link')
    link.rel = 'stylesheet'
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
    document.head.appendChild(link)
})
</script>

<style scoped>
/* Custom animations and transitions */
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Smooth transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
}
</style>