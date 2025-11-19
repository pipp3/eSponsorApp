<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon, ArrowLeftIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

defineProps({
    status: {
        type: Number,
        default: 404,
    },
});
</script>

<template>
    <Head title="Página no encontrada" />
    
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 flex items-center justify-center px-4 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute inset-0 opacity-30 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl -translate-x-1/4"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl translate-x-1/4"></div>
            <div class="absolute bottom-0 left-20 w-96 h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl -translate-y-1/4"></div>
        </div>

        <div class="relative max-w-2xl w-full text-center z-10">
            <!-- Icon -->
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <ExclamationTriangleIcon class="w-12 h-12 text-white" />
                </div>
            </div>

            <!-- Status Code -->
            <h1 class="text-8xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                {{ status }}
            </h1>

            <!-- Message -->
            <h2 class="text-4xl font-bold text-slate-800 mb-4">Página no encontrada</h2>
            <p class="text-xl text-slate-600 mb-10 max-w-lg mx-auto">
                Lo sentimos, la página que estás buscando no existe o ha sido movida.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <button
                    @click="() => window.history.back()"
                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/80 backdrop-blur-sm hover:bg-white text-slate-700 font-semibold rounded-xl border border-slate-300 shadow-lg hover:shadow-xl transition-all"
                >
                    <ArrowLeftIcon class="w-5 h-5" />
                    Volver atrás
                </button>

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
                ¿Necesitas ayuda? 
                <Link href="/" class="text-blue-600 hover:text-blue-700 font-semibold transition">
                    Contáctanos
                </Link>
            </p>
        </div>
    </div>
</template>
