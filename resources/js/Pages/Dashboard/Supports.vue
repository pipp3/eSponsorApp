<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { computed } from 'vue'
import { HeartIcon, CurrencyDollarIcon, UserGroupIcon, ChartBarIcon, GiftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  supports: {
    type: Array,
    default: () => []
  }
})

// Calcular estadísticas
const stats = computed(() => {
  const total = props.supports.reduce((sum, s) => sum + Number(s.amount), 0)
  const count = props.supports.length
  const average = count > 0 ? (total / count).toFixed(2) : 0
  
  return { total, count, average }
})

// Formatear fecha relativa en español
function formatRelativeDate(dateString) {
  if (!dateString) return ''
  
  const date = new Date(dateString)
  const now = new Date()
  const diffInSeconds = Math.floor((now - date) / 1000)
  
  if (diffInSeconds < 60) return 'Hace unos segundos'
  if (diffInSeconds < 3600) {
    const minutes = Math.floor(diffInSeconds / 60)
    return `Hace ${minutes} ${minutes === 1 ? 'minuto' : 'minutos'}`
  }
  if (diffInSeconds < 86400) {
    const hours = Math.floor(diffInSeconds / 3600)
    return `Hace ${hours} ${hours === 1 ? 'hora' : 'horas'}`
  }
  if (diffInSeconds < 604800) {
    const days = Math.floor(diffInSeconds / 86400)
    return `Hace ${days} ${days === 1 ? 'día' : 'días'}`
  }
  
  // Formato completo para fechas más antiguas
  return date.toLocaleDateString('es-ES', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Obtener iniciales del nombre
function getInitials(name) {
  if (!name) return '?'
  return name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

// Obtener color basado en el nombre (consistente)
function getAvatarColor(name) {
  const colors = [
    'bg-blue-500',
    'bg-purple-500',
    'bg-pink-500',
    'bg-green-500',
    'bg-yellow-500',
    'bg-red-500',
    'bg-indigo-500',
    'bg-teal-500'
  ]
  
  const hash = name.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)
  return colors[hash % colors.length]
}
</script>

<template>
  <DashboardLayout>
    
    <div class="max-w-5xl mx-auto">
      
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
            <HeartIcon class="w-6 h-6 text-white" />
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Apoyos Recibidos</h1>
            <p class="text-slate-600 text-sm mt-1">Gestiona y visualiza todos los apoyos que has recibido</p>
          </div>
        </div>
      </div>

      <!-- Estadísticas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm font-medium mb-1">Total Recaudado</p>
              <p class="text-3xl font-bold">${{ stats.total }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
              <CurrencyDollarIcon class="w-8 h-8" />
            </div>
          </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-purple-100 text-sm font-medium mb-1">Apoyos Totales</p>
              <p class="text-3xl font-bold">{{ stats.count }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
              <UserGroupIcon class="w-8 h-8" />
            </div>
          </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm font-medium mb-1">Promedio</p>
              <p class="text-3xl font-bold">${{ stats.average }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
              <ChartBarIcon class="w-8 h-8" />
            </div>
          </div>
        </div>

      </div>

      <!-- Lista de apoyos -->
      <div v-if="props.supports.length > 0" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50">
          <h2 class="text-lg font-semibold text-slate-900">Historial de Apoyos</h2>
        </div>

        <div class="divide-y divide-slate-200">
          <div
            v-for="support in props.supports"
            :key="support.id"
            class="p-6 hover:bg-slate-50 transition-colors"
          >
            <div class="flex items-start gap-4">
              
              <!-- Avatar -->
              <div 
                :class="[getAvatarColor(support.supporter_name), 'w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-md']"
              >
                {{ getInitials(support.supporter_name) }}
              </div>

              <!-- Contenido -->
              <div class="flex-1 min-w-0">
                
                <!-- Header -->
                <div class="flex items-start justify-between gap-4 mb-2">
                  <div>
                    <h3 class="text-lg font-semibold text-slate-900">
                      {{ support.supporter_name }}
                    </h3>
                    <p class="text-sm text-slate-500">
                      {{ formatRelativeDate(support.created_at) }}
                    </p>
                  </div>
                  
                  <!-- Monto -->
                  <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-bold text-lg flex-shrink-0">
                    ${{ support.amount }}
                  </div>
                </div>

                <!-- Mensaje -->
                <div v-if="support.message" class="mt-3 bg-slate-100 rounded-lg p-4">
                  <p class="text-slate-700 leading-relaxed">
                    "{{ support.message }}"
                  </p>
                </div>
                <div v-else class="mt-2">
                  <p class="text-slate-400 italic text-sm">Sin mensaje</p>
                </div>

              </div>

            </div>
          </div>
        </div>

      </div>

      <!-- Estado vacío -->
      <div v-else class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <div class="max-w-md mx-auto">
          <div class="bg-slate-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <GiftIcon class="w-10 h-10 text-slate-400" />
          </div>
          <h3 class="text-xl font-semibold text-slate-900 mb-2">
            Aún no tienes apoyos
          </h3>
          <p class="text-slate-600 mb-6">
            Comparte tu perfil público para comenzar a recibir contribuciones de tus seguidores
          </p>
          <button 
            @click="() => {}"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition shadow-md hover:shadow-lg"
          >
            Compartir mi Perfil
          </button>
        </div>
      </div>

    </div>

  </DashboardLayout>
</template>
