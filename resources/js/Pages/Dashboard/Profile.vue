<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import { UserIcon, DocumentDuplicateIcon } from '@heroicons/vue/24/outline'
import { ArrowPathIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const form = useForm({
  public_name: props.user.public_name ?? '',
  slug: props.user.slug ?? '',
  avatar: props.user.avatar ?? '',
  bio: props.user.bio ?? '',
})

const isFormValid = computed(() => {
  return form.slug && form.slug.length >= 3
})

const publicUrl = computed(() => {
  if (!form.slug) return ''
  return `${window.location.origin}/@${form.slug}`
})

function submit() {
  if (!isFormValid.value) return
  
  form.put('/dashboard/profile', {
    preserveScroll: true,
    onSuccess: () => {
      // Mostrar notificación de éxito
    }
  })
}

function copyUrl() {
  if (publicUrl.value) {
    navigator.clipboard.writeText(publicUrl.value)
    alert('¡URL copiada al portapapeles!')
  }
}
</script>

<template>
  <DashboardLayout>
    
    <div class="max-w-5xl mx-auto">
      
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
            <UserIcon class="w-6 h-6 text-white" />
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Editar Perfil</h1>
            <p class="text-slate-600 text-sm mt-1">Personaliza tu perfil público para que tus seguidores te conozcan mejor</p>
          </div>
        </div>
      </div>

      <form @submit.prevent="submit">
        <div class="flex flex-col lg:grid lg:grid-cols-3 gap-6">
          
          <!-- Formulario - 2 columnas -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
              
              <!-- Nombre Público -->
              <div>
                <label for="public_name" class="block text-sm font-medium text-slate-700 mb-2">
                  Nombre Público
                </label>
                <input 
                  id="public_name"
                  v-model="form.public_name" 
                  type="text"
                  class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                  :class="{
                    'border-red-500': form.errors.public_name,
                    'border-slate-300': !form.errors.public_name
                  }"
                  placeholder="Tu nombre o marca"
                  maxlength="255"
                />
                <p v-if="form.errors.public_name" class="text-red-500 text-sm mt-1">
                  {{ form.errors.public_name }}
                </p>
              </div>

              <!-- Slug -->
              <div>
                <label for="slug" class="block text-sm font-medium text-slate-700 mb-2">
                  URL Personalizada <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">@</span>
                  <input 
                    id="slug"
                    v-model="form.slug" 
                    type="text"
                    class="w-full border rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    :class="{
                      'border-red-500': form.errors.slug,
                      'border-slate-300': !form.errors.slug
                    }"
                    placeholder="tunombre"
                    pattern="[a-z0-9_-]+"
                    maxlength="50"
                    required
                  />
                </div>
                <p v-if="form.errors.slug" class="text-red-500 text-sm mt-1">
                  {{ form.errors.slug }}
                </p>
              </div>

              <!-- Avatar - ancho completo -->
              <div class="md:col-span-2">
                <label for="avatar" class="block text-sm font-medium text-slate-700 mb-2">
                  Avatar (URL de imagen)
                </label>
                <input 
                  id="avatar"
                  v-model="form.avatar" 
                  type="url"
                  class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                  :class="{
                    'border-red-500': form.errors.avatar,
                    'border-slate-300': !form.errors.avatar
                  }"
                  placeholder="https://ejemplo.com/imagen.jpg"
                />
                <p v-if="form.errors.avatar" class="text-red-500 text-sm mt-1">
                  {{ form.errors.avatar }}
                </p>
              </div>

              <!-- Biografía - ancho completo -->
              <div class="md:col-span-2">
                <label for="bio" class="block text-sm font-medium text-slate-700 mb-2">
                  Biografía
                </label>
                <textarea 
                  id="bio"
                  v-model="form.bio" 
                  rows="3"
                  class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                  :class="{
                    'border-red-500': form.errors.bio,
                    'border-slate-300': !form.errors.bio
                  }"
                  placeholder="Cuéntale a tus seguidores sobre ti..."
                  maxlength="500"
                ></textarea>
                <div class="flex justify-between items-center mt-1">
                  <p v-if="form.errors.bio" class="text-red-500 text-sm">
                    {{ form.errors.bio }}
                  </p>
                  <p class="text-slate-400 text-xs ml-auto">
                    {{ form.bio?.length || 0 }}/500
                  </p>
                </div>
              </div>

            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between mt-6 pt-6 border-t border-slate-200 gap-3 sm:gap-0">
              <div class="text-sm text-slate-500 text-center sm:text-left">
                <span v-if="form.slug">Tu URL: </span>
                <a v-if="form.slug" :href="publicUrl" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium break-all">
                  {{ publicUrl }}
                </a>
              </div>
              <button
                type="submit"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                :disabled="form.processing || !isFormValid"
              >
                <ArrowPathIcon v-if="form.processing" class="animate-spin h-4 w-4" />
                <span>{{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}</span>
              </button>
            </div>

          </div>

          <!-- Vista Previa - 1 columna -->
          <div class="lg:col-span-1 order-first lg:order-last">
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-xl border border-slate-200 p-6 lg:sticky lg:top-24">
              
              <div class="text-center space-y-4">
                <div class="inline-block">
                  <img
                    :src="form.avatar || `https://ui-avatars.com/api/?name=${form.slug || 'User'}&size=120&background=3B82F6&color=fff`"
                    class="w-24 h-24 rounded-full shadow-lg border-4 border-white object-cover"
                    :alt="form.public_name || form.slug"
                  />
                </div>

                <div>
                  <h4 class="text-xl font-bold text-slate-900">
                    {{ form.public_name || 'Tu nombre' }}
                  </h4>
                  <p class="text-slate-500 text-sm mt-1">
                    @{{ form.slug || 'tunombre' }}
                  </p>
                </div>

                <p class="text-slate-600 text-sm leading-relaxed px-2">
                  {{ form.bio || 'Tu biografía aparecerá aquí...' }}
                </p>

                <div v-if="form.slug" class="pt-4 border-t border-slate-200">
                  <button 
                    @click="copyUrl"
                    type="button"
                    class="w-full bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition flex items-center justify-center gap-2 text-sm"
                  >
                    <DocumentDuplicateIcon class="w-4 h-4" />
                    Copiar URL
                  </button>
                </div>

              </div>

            </div>
          </div>

        </div>

      </form>

    </div>

  </DashboardLayout>
</template>
