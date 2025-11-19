<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { HeartIcon, UserIcon, LinkIcon, ArrowRightIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import Footer from '@/Components/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const sidebarOpen = ref(false);

const scrollToFeatures = () => {
    document.getElementById('features')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    sidebarOpen.value = false; // Cerrar sidebar al hacer clic
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};
</script>

<template>
    <Head title="Bienvenido a eSponsor" />
    
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 relative overflow-hidden">
        <!-- Decorative background pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute -bottom-8 left-20 w-96 h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <!-- Mobile Sidebar Toggle - Solo visible en móvil -->
        <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <Link href="/" class="inline-flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                            <HeartIcon class="w-5 h-5 text-white" />
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>
                    </Link>

                    <!-- Mobile Menu Toggle -->
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 text-slate-600 hover:text-slate-900 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div 
            v-if="sidebarOpen" 
            @click="closeSidebar" 
            class="lg:hidden fixed inset-0 bg-black/50 z-40"
        ></div>

        <!-- Mobile Sidebar -->
        <aside 
            v-if="canLogin" 
            class="lg:hidden fixed right-0 top-0 h-full w-80 bg-white shadow-xl transform transition-transform duration-300 ease-in-out z-50"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'"
        >
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-6 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                            <HeartIcon class="w-5 h-5 text-white" />
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>
                    </div>
                    <button 
                        @click="closeSidebar" 
                        class="p-2 text-slate-400 hover:text-slate-600 transition-colors"
                    >
                        <XMarkIcon class="w-6 h-6" />
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 p-6 space-y-2">
                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard.profile')"
                            @click="closeSidebar"
                            class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium"
                        >
                            <div class="w-5 h-5">
                                <UserIcon class="w-5 h-5" />
                            </div>
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            @click="closeSidebar"
                            class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium"
                        >
                            <div class="w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            Iniciar Sesión
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            @click="closeSidebar"
                            class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl"
                        >
                            <div class="w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            Registrarse
                        </Link>
                    </template>
                </nav>

                <!-- Footer del Sidebar -->
                <div class="p-6 border-t border-slate-200">
                    <button
                        @click="scrollToFeatures"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 font-medium rounded-lg border border-slate-200 transition-all duration-200"
                    >
                        <span>Conocer más</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <div class="relative">
            <!-- Desktop Header - Oculto en móvil -->
            <header class="hidden lg:block border-b border-slate-200/50 bg-white/50 backdrop-blur-sm sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Logo -->
                        <Link href="/" class="inline-flex items-center gap-2 group">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <HeartIcon class="w-5 h-5 sm:w-6 sm:h-6 text-white" />
                            </div>
                            <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>
                        </Link>

                        <!-- Desktop Navigation -->
                        <nav v-if="canLogin" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-6">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard.profile')"
                                class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition text-sm sm:text-base text-center"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition text-sm sm:text-base text-center"
                                >
                                    Iniciar Sesión
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 text-sm sm:text-base text-center"
                                >
                                    Registrarse
                                </Link>
                            </template>
                        </nav>
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 lg:pt-20 pb-20">
                <div class="text-center max-w-4xl mx-auto mb-20">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Recibe apoyo de</span>
                        <br />
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">tus seguidores</span>
                    </h1>
                    <p class="text-xl text-slate-600 mb-10 leading-relaxed">
                        Crea tu perfil, comparte tus links y empieza a recibir contribuciones de las personas que valoran tu trabajo.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link
                            :href="route('register')"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 text-lg"
                        >
                            <HeartIcon class="w-6 h-6" />
                            Comienza Gratis
                        </Link>
                        <button
                            @click="scrollToFeatures"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/80 backdrop-blur-sm hover:bg-white text-slate-700 font-bold rounded-xl border border-slate-200 shadow-lg hover:shadow-xl transition-all text-lg"
                        >
                            Conocer más
                        </button>
                    </div>
                </div>

                <!-- Features -->
                <div id="features" class="grid md:grid-cols-3 gap-8 mb-20 scroll-mt-24">
                    <!-- Feature 1 -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-slate-200/50 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                            <UserIcon class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Perfil Personalizado</h3>
                        <p class="text-slate-600 leading-relaxed">Crea tu página única con tu nombre, foto, biografía y todos tus links importantes en un solo lugar.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-slate-200/50 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                            <LinkIcon class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Links Ilimitados</h3>
                        <p class="text-slate-600 leading-relaxed">Agrega todos los enlaces que necesites: redes sociales, portafolio, tienda, blog y mucho más.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-slate-200/50 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                            <HeartIcon class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Recibe Apoyos</h3>
                        <p class="text-slate-600 leading-relaxed">Permite que tus seguidores te envíen contribuciones monetarias con mensajes de apoyo personalizados.</p>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-12 text-center shadow-2xl">
                    <h2 class="text-4xl font-bold text-white mb-4">¿Listo para comenzar?</h2>
                    <p class="text-xl text-blue-100 mb-8">Únete a miles de creadores que ya están recibiendo apoyo</p>
                    <Link
                        :href="route('register')"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white hover:bg-slate-50 text-blue-600 font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 text-lg"
                    >
                        Crear mi cuenta gratis
                        <ArrowRightIcon class="w-5 h-5" />
                    </Link>
                </div>
            </main>

            <!-- Footer -->
            <Footer />
        </div>
    </div>
</template>