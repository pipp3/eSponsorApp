<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  slug: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['success'])

const form = useForm({
  supporter_name: '',
  amount: 5,
  message: ''
})

const isFormValid = computed(() => {
  return form.supporter_name.trim().length > 0 && 
         form.amount >= 1 && 
         form.amount <= 100
})

function submit() {
  if (!isFormValid.value) return
  
  form.post(`/@${props.slug}/support`, {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      emit('success')
    },
    onError: (errors) => {
      console.error('Error al enviar apoyo:', errors)
    }
  })
}
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Enviar Apoyo</h2>
      <p class="text-sm text-gray-600 mt-1">Apoya a este creador con un mensaje y una contribución</p>
    </div>

    <form @submit.prevent="submit" class="space-y-5">
      
      <!-- Nombre del apoyo -->
      <div>
        <label for="supporter_name" class="block text-sm font-medium text-gray-700 mb-1">
          Tu nombre <span class="text-red-500">*</span>
        </label>
        <input 
          id="supporter_name"
          v-model="form.supporter_name" 
          type="text"
          class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
          :class="{
            'border-red-500': form.errors.supporter_name,
            'border-gray-300': !form.errors.supporter_name
          }"
          placeholder="Ej: Juan Pérez"
          maxlength="255"
          required
        />
        <p v-if="form.errors.supporter_name" class="text-red-500 text-sm mt-1">
          {{ form.errors.supporter_name }}
        </p>
      </div>

      <!-- Monto -->
      <div>
        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
          Monto <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
          <input 
            id="amount"
            v-model.number="form.amount" 
            type="number" 
            min="1" 
            max="100"
            step="1"
            class="w-full border rounded-lg pl-8 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
            :class="{
              'border-red-500': form.errors.amount,
              'border-gray-300': !form.errors.amount
            }"
            required
          />
        </div>
        <p v-if="form.errors.amount" class="text-red-500 text-sm mt-1">
          {{ form.errors.amount }}
        </p>
        <p v-else class="text-gray-500 text-xs mt-1">
          Monto entre $1 y $100
        </p>
      </div>

      <!-- Mensaje -->
      <div>
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
          Mensaje (opcional)
        </label>
        <textarea 
          id="message"
          v-model="form.message" 
          rows="3"
          class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
          :class="{
            'border-red-500': form.errors.message,
            'border-gray-300': !form.errors.message
          }"
          placeholder="¡Escribe un mensaje de apoyo! 💬"
          maxlength="500"
        ></textarea>
        <div class="flex justify-between items-center mt-1">
          <p v-if="form.errors.message" class="text-red-500 text-sm">
            {{ form.errors.message }}
          </p>
          <p class="text-gray-400 text-xs ml-auto">
            {{ form.message.length }}/500
          </p>
        </div>
      </div>

      <!-- Botones -->
      <div class="flex gap-3 pt-2">
        <button 
          type="submit"
          class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          :disabled="form.processing || !isFormValid"
        >
          <span v-if="form.processing" class="flex items-center justify-center gap-2">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Enviando...
          </span>
          <span v-else>Enviar Apoyo de ${{ form.amount }}</span>
        </button>
      </div>

    </form>
  </div>
</template>
