<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Crear Cuenta" />

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Únete a eSponsor</h2>
            <p class="text-slate-600 mt-2">Crea tu cuenta y empieza a recibir apoyos</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="name" class="text-slate-700 font-semibold">
                    <span>Nombre completo</span>
                    <span class="text-red-500 ml-1">*</span>
                </InputLabel>

                <TextInput
                    id="name"
                    type="text"
                    :class="[
                        'mt-2 block w-full rounded-xl shadow-sm transition',
                        form.errors.name 
                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                            : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500'
                    ]"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Tu nombre"
                />

                <InputError :message="form.errors.name" />
            </div>

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
                        autocomplete="new-password"
                        placeholder="Mínimo 8 caracteres"
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

            <div>
                <InputLabel for="password_confirmation" class="text-slate-700 font-semibold">
                    <span>Confirmar contraseña</span>
                    <span class="text-red-500 ml-1">*</span>
                </InputLabel>

                <div class="relative">
                    <TextInput
                        id="password_confirmation"
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        :class="[
                            'mt-2 block w-full rounded-xl shadow-sm transition pr-10',
                            form.errors.password_confirmation 
                                ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                                : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500'
                        ]"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repite tu contraseña"
                    />
                    <button
                        type="button"
                        @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition"
                    >
                        <EyeIcon v-if="!showPasswordConfirmation" class="w-5 h-5" />
                        <EyeSlashIcon v-else class="w-5 h-5" />
                    </button>
                </div>

                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="space-y-4 pt-2">
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="form.processing"
                >
                    <svg v-if="form.processing" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ form.processing ? 'Creando cuenta...' : 'Crear Cuenta' }}
                </button>

                <div class="text-center">
                    <span class="text-slate-600 text-sm">¿Ya tienes cuenta? </span>
                    <Link
                        :href="route('login')"
                        class="text-sm text-blue-600 hover:text-blue-700 font-semibold transition"
                    >
                        Inicia sesión
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
