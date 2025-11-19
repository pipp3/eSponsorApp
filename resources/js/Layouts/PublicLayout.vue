<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 relative overflow-hidden">
    <!-- Decorative background pattern -->
    <div class="absolute inset-0 opacity-20 sm:opacity-30">
      <div class="absolute top-0 -left-4 w-64 h-64 sm:w-96 sm:h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl"></div>
      <div class="absolute top-0 -right-4 w-64 h-64 sm:w-96 sm:h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl"></div>
      <div class="absolute -bottom-8 left-20 w-64 h-64 sm:w-96 sm:h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl"></div>
    </div>

    <!-- Header with logo/brand -->
    <header class="relative">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <a href="/" class="inline-flex items-center gap-2 group">
          <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
          </div>
          <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>
        </a>
      </div>
    </header>

    <main class="relative max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 sm:pb-12">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200/50 bg-white/50 backdrop-blur-sm mt-20">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="text-center sm:text-left">
            <p class="text-slate-600 text-sm">
              © 2025 <span class="font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">eSponsor</span>. 
              Todos los derechos reservados.
            </p>
          </div>
          
          <div class="flex items-center gap-2">
            <span class="text-slate-600 text-sm">Created by</span>
            <a 
              href="https://github.com/pipp3" 
              target="_blank" 
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 text-white text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-lg group"
            >
              <!-- GitHub Icon -->
              <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
              </svg>
              Pipp3
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
