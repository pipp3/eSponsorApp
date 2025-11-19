<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue'
import Modal from '@/Components/Modal.vue'
import SupportForm from '@/Components/SupportForm.vue'
import { ref } from 'vue'
import { HeartIcon, CheckCircleIcon, ArrowTopRightOnSquareIcon, LinkIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  creator: Object,
  links: Array
})

const showSupport = ref(false)
const showSuccessMessage = ref(false)

function handleSupportSuccess() {
  showSupport.value = false
  showSuccessMessage.value = true
  
  setTimeout(() => {
    showSuccessMessage.value = false
  }, 5000)
}

function closeModal() {
  showSupport.value = false
}
</script>

<template>
  <PublicLayout>

    <!-- Mensaje de éxito -->
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="showSuccessMessage" class="fixed top-6 right-6 z-50 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 max-w-md backdrop-blur-sm">
        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
          <CheckCircleIcon class="w-6 h-6" />
        </div>
        <div>
          <p class="font-bold text-lg">¡Apoyo enviado con éxito!</p>
          <p class="text-sm opacity-95">Gracias por tu contribución</p>
        </div>
      </div>
    </Transition>

    <!-- Profile Card -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8 sm:p-12 border border-slate-200/50">
      
      <!-- Avatar & Name Section -->
      <div class="text-center space-y-6">
        <!-- Avatar -->
        <div>
          <img
            :src="creator.avatar || 'https://ui-avatars.com/api/?name=' + creator.slug + '&size=160&background=gradient&color=fff'"
            class="w-32 h-32 rounded-full mx-auto border-4 border-white object-cover"
            :alt="creator.public_name || creator.slug"
          />
        </div>

        <!-- Name & Username -->
        <div>
          <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
            {{ creator.public_name || '@' + creator.slug }}
          </h1>
          <p class="text-slate-500 text-lg mt-2 font-medium">@{{ creator.slug }}</p>
        </div>

        <!-- Bio -->
        <p v-if="creator.bio" class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">
          {{ creator.bio }}
        </p>

        <!-- Support Button -->
        <button
          @click="showSupport = true"
          class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-8 py-4 rounded-xl text-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95"
        >
          <HeartIcon class="w-6 h-6" />
          Apoyar a {{ creator.public_name || creator.slug }}
        </button>
      </div>
    </div>

    <!-- Links Section -->
    <div v-if="links.length > 0" class="mt-8 space-y-4 max-w-2xl mx-auto">
      <a
        v-for="link in links"
        :key="link.id"
        :href="link.url"
        target="_blank"
        rel="noopener noreferrer"
        class="group block bg-white/80 backdrop-blur-sm hover:bg-white shadow-lg hover:shadow-2xl p-6 rounded-2xl text-center font-bold text-slate-800 transition-all transform hover:scale-105 active:scale-95 border border-slate-200/50 relative overflow-hidden"
      >
        <!-- Hover gradient effect -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <div class="relative flex items-center justify-center gap-3">
          <span class="text-lg">{{ link.title }}</span>
          <ArrowTopRightOnSquareIcon class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-all group-hover:translate-x-1" />
        </div>
      </a>
    </div>

    <div v-else class="mt-8 text-center">
      <div class="inline-flex items-center gap-2 text-slate-400 bg-slate-100 px-6 py-3 rounded-xl">
        <LinkIcon class="w-5 h-5" />
        <p class="font-medium">No hay links disponibles todavía</p>
      </div>
    </div>

    <!-- Modal de apoyo -->
    <Modal :show="showSupport" @close="closeModal" max-width="md">
      <SupportForm :slug="creator.slug" @success="handleSupportSuccess" />
    </Modal>

  </PublicLayout>
</template>
