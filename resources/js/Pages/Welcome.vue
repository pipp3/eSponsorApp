<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { HeartIcon, UserIcon, LinkIcon, ArrowRightIcon } from '@heroicons/vue/24/solid';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const scrollToFeatures = () => {
    document.getElementById('features')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

        <div class="relative">
            <!-- Header -->
            <header class="border-b border-slate-200/50 bg-white/50 backdrop-blur-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Logo -->
                        <Link href="/" class="inline-flex items-center gap-2 group">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <HeartIcon class="w-6 h-6 text-white" />
                            </div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>
                        </Link>

                        <!-- Navigation -->
                        <nav v-if="canLogin" class="flex items-center gap-4">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard.profile')"
                                class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition"
                                >
                                    Iniciar Sesión
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105"
                                >
                                    Registrarse
                                </Link>
                            </template>
                        </nav>
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
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
            <footer class="border-t border-slate-200/50 bg-white/50 backdrop-blur-sm mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <p class="text-center text-slate-600">
                        © 2025 <span class="font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>. Todos los derechos reservados.
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>