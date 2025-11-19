<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { LinkIcon, PlusIcon, Bars2Icon, ArrowTopRightOnSquareIcon, TrashIcon, ExclamationTriangleIcon, PencilIcon, CheckIcon } from '@heroicons/vue/24/outline'
import { ArrowPathIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  links: {
    type: Array,
    default: () => []
  }
})

const form = useForm({
  title: '',
  url: '',
  position: props.links.length
})

const editingId = ref(null)
const showForm = ref(false)
const showDeleteModal = ref(false)
const linkToDelete = ref(null)
const isReordering = ref(false)
const reorderedLinks = ref([])
const draggedIndex = ref(null)
const isSavingOrder = ref(false)
const showSuccessMessage = ref(false)
const successMessage = ref('')

const sortedLinks = computed(() => {
  return [...props.links].sort((a, b) => a.position - b.position)
})

const isFormValid = computed(() => {
  return form.title.trim().length > 0 && form.url.trim().length > 0
})

function toggleForm() {
  showForm.value = !showForm.value
  if (!showForm.value) {
    form.reset()
  }
}

function create() {
  if (!isFormValid.value) return
  
  const maxPosition = props.links.length > 0 
    ? Math.max(...props.links.map(l => l.position))
    : -1
  form.position = maxPosition + 1
  
  form.post('/dashboard/links', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      form.position = 0
      showForm.value = false
    },
    onError: (errors) => {
      console.error('Errores:', errors)
    }
  })
}

function remove(id) {
  linkToDelete.value = props.links.find(link => link.id === id)
  showDeleteModal.value = true
}

function confirmDelete() {
  if (linkToDelete.value) {
    useForm({}).delete(`/dashboard/links/${linkToDelete.value.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        showDeleteModal.value = false
        linkToDelete.value = null
      }
    })
  }
}

function cancelDelete() {
  showDeleteModal.value = false
  linkToDelete.value = null
}

function startReordering() {
  isReordering.value = true
  reorderedLinks.value = [...sortedLinks.value]
}

function cancelReordering() {
  isReordering.value = false
  reorderedLinks.value = []
}

function onDragStart(index) {
  draggedIndex.value = index
}

function onDragOver(event, index) {
  event.preventDefault()
  if (draggedIndex.value === null || draggedIndex.value === index) return
  
  const items = [...reorderedLinks.value]
  const draggedItem = items[draggedIndex.value]
  items.splice(draggedIndex.value, 1)
  items.splice(index, 0, draggedItem)
  
  reorderedLinks.value = items
  draggedIndex.value = index
}

function onDragEnd() {
  draggedIndex.value = null
}

function saveOrder() {
  isSavingOrder.value = true
  
  const updates = reorderedLinks.value.map((link, index) => ({
    id: link.id,
    position: index
  }))
  
  useForm({ links: updates }).put('/dashboard/links/reorder', {
    preserveScroll: true,
    onSuccess: () => {
      isReordering.value = false
      reorderedLinks.value = []
      isSavingOrder.value = false
      
      successMessage.value = 'Orden actualizado correctamente'
      showSuccessMessage.value = true
      
      setTimeout(() => {
        showSuccessMessage.value = false
      }, 3000)
    },
    onError: (errors) => {
      console.error('Error al reordenar:', errors)
      isSavingOrder.value = false
    }
  })
}

function getUrlDomain(url) {
  try {
    const urlObj = new URL(url.startsWith('http') ? url : `https://${url}`)
    return urlObj.hostname.replace('www.', '')
  } catch {
    return url
  }
}
</script>

<template>
  <DashboardLayout>
    
    <!-- Mensaje de éxito -->
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-2"
    >
      <div 
        v-if="showSuccessMessage"
        class="fixed top-16 sm:top-20 right-4 sm:right-8 z-50 bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg flex items-center gap-2 sm:gap-3"
      >
        <CheckIcon class="w-5 h-5 sm:w-6 sm:h-6" />
        <span class="font-semibold text-sm sm:text-base">{{ successMessage }}</span>
      </div>
    </Transition>

    <div class="max-w-4xl mx-auto">
      
      <!-- Header -->
      <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
            <LinkIcon class="w-5 h-5 sm:w-6 sm:h-6 text-white" />
          </div>
          <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Mis Links</h1>
            <p class="text-slate-600 text-sm mt-1">Gestiona los enlaces que aparecen en tu perfil público</p>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
          <!-- Botones de reordenamiento -->
          <template v-if="sortedLinks.length > 1">
            <template v-if="isReordering">
              <button
                @click="cancelReordering"
                class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-slate-300 transition flex items-center gap-1 sm:gap-2 text-sm sm:text-base"
              >
                <span class="hidden sm:inline">Cancelar</span>
                <span class="sm:hidden">✕</span>
              </button>
              <button
                @click="saveOrder"
                :disabled="isSavingOrder"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-3 sm:px-4 py-2 sm:py-3 rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-1 sm:gap-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base"
              >
                <ArrowPathIcon v-if="isSavingOrder" class="animate-spin w-4 h-4 sm:w-5 sm:h-5" />
                <CheckIcon v-else class="w-4 h-4 sm:w-5 sm:h-5" />
                <span class="hidden sm:inline">{{ isSavingOrder ? 'Guardando...' : 'Guardar Orden' }}</span>
                <span class="sm:hidden">Guardar</span>
              </button>
            </template>
            <button
              v-else
              @click="startReordering"
              class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-slate-300 transition flex items-center gap-1 sm:gap-2 text-sm sm:text-base"
            >
              <PencilIcon class="w-4 h-4 sm:w-5 sm:h-5" />
              <span class="hidden sm:inline">Editar Orden</span>
              <span class="sm:hidden">Ordenar</span>
            </button>
          </template>
          
          <!-- Botón nuevo link -->
          <button
            v-if="!isReordering"
            @click="toggleForm"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-1 sm:gap-2 text-sm sm:text-base"
          >
            <PlusIcon class="w-4 h-4 sm:w-5 sm:h-5" />
            <span>{{ showForm ? 'Cancelar' : 'Nuevo Link' }}</span>
          </button>
        </div>
      </div>

      <!-- Formulario de crear link -->
      <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div v-if="showForm" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-4 sm:mb-6">
          
          <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50">
            <h2 class="text-base sm:text-lg font-semibold text-slate-900">Agregar Nuevo Link</h2>
          </div>

          <form @submit.prevent="create" class="p-4 sm:p-6">
            <div class="space-y-3 sm:space-y-4">
              
              <!-- Título -->
              <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1 sm:mb-2">
                  Título del Link <span class="text-red-500">*</span>
                </label>
                <input 
                  id="title"
                  v-model="form.title" 
                  type="text"
                  class="w-full border rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base"
                  :class="{
                    'border-red-500': form.errors.title,
                    'border-slate-300': !form.errors.title
                  }"
                  placeholder="Ej: Mi portafolio, Mi canal de YouTube"
                  maxlength="255"
                  required
                />
                <p v-if="form.errors.title" class="text-red-500 text-xs sm:text-sm mt-1">
                  {{ form.errors.title }}
                </p>
              </div>

              <!-- URL -->
              <div>
                <label for="url" class="block text-sm font-medium text-slate-700 mb-1 sm:mb-2">
                  URL <span class="text-red-500">*</span>
                </label>
                <input 
                  id="url"
                  v-model="form.url" 
                  type="text"
                  class="w-full border rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm sm:text-base"
                  :class="{
                    'border-red-500': form.errors.url,
                    'border-slate-300': !form.errors.url
                  }"
                  placeholder="https://ejemplo.com o ejemplo.com"
                  required
                />
                <p v-if="form.errors.url" class="text-red-500 text-xs sm:text-sm mt-1">
                  {{ form.errors.url }}
                </p>
              </div>

            </div>

            <!-- Botón submit -->
            <div class="mt-4 sm:mt-6">
              <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2.5 sm:py-3 rounded-lg transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-sm sm:text-base"
                :disabled="form.processing || !isFormValid"
              >
                <ArrowPathIcon v-if="form.processing" class="animate-spin h-4 w-4 sm:h-5 sm:w-5" />
                <span>{{ form.processing ? 'Agregando...' : 'Agregar Link' }}</span>
              </button>
            </div>

          </form>

        </div>
      </Transition>

      <!-- Lista de links -->
      <div v-if="sortedLinks.length > 0" class="space-y-3">
        
        <div
          v-for="(link, index) in (isReordering ? reorderedLinks : sortedLinks)"
          :key="link.id"
          :draggable="isReordering"
          @dragstart="onDragStart(index)"
          @dragover="onDragOver($event, index)"
          @dragend="onDragEnd"
          class="group bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-all overflow-hidden"
          :class="{ 'cursor-move': isReordering, 'opacity-50': draggedIndex === index }"
        >
          <div class="p-3 sm:p-5 flex items-center gap-3 sm:gap-4">
            
            <!-- Drag handle -->
            <div 
              class="text-slate-400 flex-shrink-0"
              :class="isReordering ? 'cursor-move' : 'cursor-default'"
            >
              <Bars2Icon class="w-4 h-4 sm:w-5 sm:h-5" />
            </div>

            <!-- Link info -->
            <div class="flex-1 min-w-0">
              <h3 class="font-semibold text-slate-900 text-base sm:text-lg mb-0.5 sm:mb-1">
                {{ link.title }}
              </h3>
              <a 
                :href="link.url" 
                target="_blank" 
                rel="noopener noreferrer"
                class="text-blue-600 hover:text-blue-700 text-xs sm:text-sm flex items-center gap-1 group/link"
                @click.stop
              >
                <span class="truncate">{{ getUrlDomain(link.url) }}</span>
                <ArrowTopRightOnSquareIcon class="w-3 h-3 sm:w-4 sm:h-4 opacity-0 group-hover/link:opacity-100 transition" />
              </a>
            </div>

            <!-- Posición badge -->
            <div class="flex-shrink-0">
              <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                #{{ (isReordering ? index : link.position) + 1 }}
              </span>
            </div>

            <!-- Acciones -->
            <div 
              v-if="!isReordering"
              class="flex-shrink-0 flex items-center gap-1 sm:gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition"
            >
              <button
                @click="remove(link.id)"
                class="p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                title="Eliminar link"
              >
                <TrashIcon class="w-4 h-4 sm:w-5 sm:h-5" />
              </button>
            </div>

          </div>
        </div>

      </div>

      <!-- Estado vacío -->
      <div v-else class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-6 sm:p-12 text-center">
        <div class="max-w-md mx-auto">
          <div class="bg-slate-100 w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
            <LinkIcon class="w-8 h-8 sm:w-10 sm:h-10 text-slate-400" />
          </div>
          <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-1 sm:mb-2">
            No tienes links todavía
          </h3>
          <p class="text-slate-600 mb-4 sm:mb-6 text-sm sm:text-base">
            Agrega enlaces a tus redes sociales, portafolio, tienda o cualquier otro contenido
          </p>
          <button 
            @click="showForm = true"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg transition shadow-md hover:shadow-lg text-sm sm:text-base"
          >
            Crear mi Primer Link
          </button>
        </div>
      </div>

    </div>

    <!-- Modal de confirmación de eliminación -->
    <Modal :show="showDeleteModal" @close="cancelDelete" max-width="md">
      <div class="p-6">
        
        <!-- Icono de advertencia -->
        <div class="flex items-center justify-center mb-4">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
            <ExclamationTriangleIcon class="w-8 h-8 text-red-600" />
          </div>
        </div>

        <!-- Título y mensaje -->
        <div class="text-center mb-6">
          <h3 class="text-xl font-bold text-slate-900 mb-2">
            ¿Eliminar este link?
          </h3>
          <p class="text-slate-600 mb-4">
            Esta acción no se puede deshacer. El link será eliminado permanentemente de tu perfil.
          </p>
          
          <!-- Detalles del link a eliminar -->
          <div v-if="linkToDelete" class="bg-slate-50 rounded-lg p-4 text-left">
            <p class="font-semibold text-slate-900 mb-1">{{ linkToDelete.title }}</p>
            <p class="text-sm text-slate-500 truncate">{{ linkToDelete.url }}</p>
          </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex gap-3">
          <button
            @click="cancelDelete"
            type="button"
            class="flex-1 bg-white hover:bg-slate-50 text-slate-700 font-semibold px-4 py-3 rounded-lg border border-slate-300 transition"
          >
            Cancelar
          </button>
          <button
            @click="confirmDelete"
            type="button"
            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-3 rounded-lg shadow-md hover:shadow-lg transition"
          >
            Eliminar
          </button>
        </div>

      </div>
    </Modal>

  </DashboardLayout>
</template>