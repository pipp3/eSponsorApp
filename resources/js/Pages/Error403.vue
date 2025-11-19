<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

defineProps({
    status: {
        type: Number,
        default: 403,
    },
});
</script>

<template>
    <Head title="Acceso Denegado" />
    
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 flex items-center justify-center px-4 overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute inset-0 opacity-30 pointer-events-none">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute -bottom-8 left-20 w-96 h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="relative max-w-2xl text-center">
            <!-- Lock Icon -->
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-red-600 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <LockClosedIcon class="w-12 h-12 text-white" />
                </div>
            </div>

            <!-- Message -->
            <h2 class="text-4xl font-bold text-slate-800 mb-4">Acceso Denegado</h2>
            <p class="text-xl text-slate-600 mb-10 max-w-lg mx-auto">
                No tienes permiso para acceder a esta página. Por favor, inicia sesión con una cuenta autorizada.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <Link
                    href="/login"
                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/80 backdrop-blur-sm hover:bg-white text-slate-700 font-semibold rounded-xl border border-slate-300 shadow-lg hover:shadow-xl transition-all"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Iniciar Sesión
                </Link>

                <Link
                    href="/"
                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105"
                >
                    <HomeIcon class="w-5 h-5" />
                    Ir al inicio
                </Link>
            </div>

            <!-- Additional Help -->
            <p class="text-slate-600">
                ¿No tienes una cuenta? 
                <Link href="/register" class="text-blue-600 hover:text-blue-700 font-semibold transition">
                    Regístrate gratis
                </Link>
            </p>
        </div>
    </div>
</template>
