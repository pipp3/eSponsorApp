<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { BoltIcon, UserIcon, LinkIcon, HeartIcon, ArrowRightOnRectangleIcon, CalendarIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline'
import Footer from '@/Components/Footer.vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const sidebarOpen = ref(false)

// Verificar si una ruta está activa
function isActive(path) {
  return window.location.pathname === path
}

// Obtener iniciales del usuario
const userInitials = computed(() => {
  if (!user.value?.name) return 'U'
  return user.value.name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">

    <!-- Mobile Header -->
    <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-slate-200/50">
      <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
            <BoltIcon class="w-5 h-5 text-white" />
          </div>
          <h2 class="text-base font-bold text-slate-900">eSponsor</h2>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-600 hover:text-slate-900 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div 
      v-if="sidebarOpen" 
      @click="sidebarOpen = false" 
      class="lg:hidden fixed inset-0 bg-black/50 z-40"
    ></div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 lg:top-0 h-full w-72 bg-white border-r border-slate-200 shadow-sm flex flex-col transform transition-transform duration-300 ease-in-out z-40"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
      
      <!-- Header del Sidebar -->
      <div class="p-4 lg:p-6 border-b border-slate-200">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg lg:rounded-xl flex items-center justify-center shadow-md">
            <BoltIcon class="w-5 h-5 lg:w-6 lg:h-6 text-white" />
          </div>
          <div>
            <h2 class="text-base lg:text-lg font-bold text-slate-900">eSponsor</h2>
            <p class="text-xs text-slate-500">Panel de control</p>
          </div>
        </div>
      </div>

      <!-- Perfil del usuario -->
      <div v-if="user" class="p-4 lg:p-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-base lg:text-lg shadow-md">
            {{ userInitials }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-slate-900 text-sm lg:text-base truncate">{{ user.name }}</p>
            <p class="text-xs text-slate-500 truncate">{{ user.email }}</p>
          </div>
        </div>
      </div>

      <!-- Navegación -->
      <nav class="flex-1 px-4 py-4 lg:py-6 space-y-1 overflow-y-auto">
        
        <Link 
          href="/dashboard/profile" 
          class="group flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg lg:rounded-xl transition-all duration-200"
          :class="isActive('/dashboard/profile') 
            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' 
            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
          @click="sidebarOpen = false"
        >
          <UserIcon class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" />
          <span class="font-medium text-sm lg:text-base">Mi Perfil</span>
        </Link>

        <Link 
          href="/dashboard/links" 
          class="group flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg lg:rounded-xl transition-all duration-200"
          :class="isActive('/dashboard/links') 
            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' 
            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
          @click="sidebarOpen = false"
        >
          <LinkIcon class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" />
          <span class="font-medium text-sm lg:text-base">Mis Links</span>
        </Link>

        <Link 
          href="/dashboard/supports" 
          class="group flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg lg:rounded-xl transition-all duration-200"
          :class="isActive('/dashboard/supports') 
            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' 
            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
          @click="sidebarOpen = false"
        >
          <HeartIcon class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" />
          <span class="font-medium text-sm lg:text-base">Apoyos Recibidos</span>
        </Link>

        <div class="pt-4 mt-4 border-t border-slate-200">
          <Link 
            v-if="user?.slug"
            :href="`/@${user.slug}`" 
            target="_blank"
            class="group flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg lg:rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200"
          >
            <ArrowTopRightOnSquareIcon class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" />
            <span class="font-medium text-sm lg:text-base">Ver mi Perfil Público</span>
          </Link>
        </div>

      </nav>

      <!-- Footer del Sidebar -->
      <div class="p-3 lg:p-4 border-t border-slate-200">
        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="w-full flex items-center justify-center gap-2 px-3 lg:px-4 py-2.5 lg:py-3 bg-slate-100 hover:bg-red-500 text-slate-700 hover:text-white font-medium rounded-lg lg:rounded-xl transition-all duration-200 group text-sm lg:text-base"
        >
          <ArrowRightOnRectangleIcon class="w-4 h-4 lg:w-5 lg:h-5" />
          <span>Cerrar Sesión</span>
        </Link>
      </div>

    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30"></div>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen pt-16 lg:pt-0">
      
      <!-- Header superior -->
      <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 sticky top-0 z-10 hidden lg:block">
        <div class="px-4 sm:px-6 lg:px-8 py-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 text-sm text-slate-500">
              <CalendarIcon class="w-4 h-4" />
              <span>{{ new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
            </div>
            
            <div class="flex items-center gap-4">
              <!-- Link a perfil público -->
              <Link 
                v-if="user?.slug"
                :href="`/@${user.slug}`" 
                target="_blank"
                class="flex items-center gap-2 text-sm text-slate-600 hover:text-blue-600 transition"
              >
                <ArrowTopRightOnSquareIcon class="w-4 h-4" />
                <span class="font-medium">Ver Perfil Público</span>
              </Link>

              <!-- Usuario -->
             
            </div>
          </div>
        </div>
      </header>

      <!-- Contenido -->
      <div class="p-4 sm:p-6 lg:p-8">
        <slot />
      </div>

      

    </main>
<!-- Footer -->
      <Footer />
  </div>
  
</template>
