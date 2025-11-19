<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline';

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

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Bienvenido de nuevo</h2>
            <p class="text-slate-600 mt-2">Ingresa a tu cuenta para continuar</p>
        </div>

        <div v-if="status" class="mb-6 p-4 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-xl">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" class="text-slate-700 font-semibold">
                    <span>Correo electrónico</span>
                    <span class="text-red-500 ml-1">*</span>
                </InputLabel>

                <TextInput
                    id="email"
                    type="email"
                    :class="[
                        'mt-2 block w-full rounded-xl shadow-sm transition',
                        form.errors.email 
                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                            : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500'
                    ]"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="tu@email.com"
                />

                <InputError :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" class="text-slate-700 font-semibold">
                    <span>Contraseña</span>
                    <span class="text-red-500 ml-1">*</span>
                </InputLabel>

                <div class="relative">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        :class="[
                            'mt-2 block w-full rounded-xl shadow-sm transition pr-10',
                            form.errors.password 
                                ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                                : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500'
                        ]"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition"
                    >
                        <EyeIcon v-if="!showPassword" class="w-5 h-5" />
                        <EyeSlashIcon v-else class="w-5 h-5" />
                    </button>
                </div>

                <InputError :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center group cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded" />
                    <span class="ms-2 text-sm text-slate-600 group-hover:text-slate-800 transition">Recordarme</span>
                </label>
            </div>

            <div class="space-y-4">
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="form.processing"
                >
                    <svg v-if="form.processing" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ form.processing ? 'Ingresando...' : 'Iniciar Sesión' }}
                </button>

                <div class="text-center">
                    <span class="text-slate-600 text-sm">¿No tienes cuenta? </span>
                    <Link :href="route('register')" class="text-sm text-blue-600 hover:text-blue-700 font-semibold transition">
                        Regístrate gratis
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
