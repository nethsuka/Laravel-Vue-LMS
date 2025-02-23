<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { usePreventDevTools } from '@/Components/DisableDevTools';
usePreventDevTools()
defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});
</script>

<template>
  <Head title="Welcome" />
  <div class="min-h-screen bg-gradient-to-b from-teal-600 to-teal-400 text-white flex flex-col animate-gradient-x">
    <div class="flex-grow flex items-center justify-center">
      <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
        <main class="text-center">
            <div class="flex justify-center mb-6 animate-fade-in-up transform hover:scale-105 transition-transform duration-300">
                <img src="../../assets/Logo.svg" alt="MHCHEM Logo" class="h-16 w-auto">
            </div>
          <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-12 animate-fade-in-down">
            <span class="block transform hover:scale-105 transition-transform duration-300">Welcome to the</span>
            <span class="block transform hover:scale-105 transition-transform duration-300">MHCHEM Learning Portal test</span>
          </h1>
          <div 
            v-if="!$page.props.auth.user" 
            class="flex justify-center gap-4 animate-fade-in-up"
          >
            <Link
              :href="route('login')"
              class="rounded-full px-8 py-3 w-32 bg-lime-400  text-[#18735c] font-semibold 
                     hover:scale-105
                     transition-all duration-300 ease-in-out
                     inline-flex items-center justify-center"
            >
              Login
            </Link>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="rounded-full px-8 py-3 w-32 bg-lime-400 text-[#18735c] font-semibold 
                     hover:scale-105
                     transition-all duration-300 ease-in-out
                     inline-flex items-center justify-center"
            >
              Register
            </Link>
          </div>
          <Link
            v-else
            :href="route('dashboard')"
            class="rounded-full px-8 py-3 bg-lime-400 text-[#18735c] font-semibold 
                   hover:scale-105
                   transition-all duration-300 ease-in-out
                   inline-flex items-center animate-fade-in-up"
          >
            Go to Dashboard
            <span class="ml-2 transform transition-transform group-hover:translate-x-1">→</span>
          </Link>
        </main>
      </div>
    </div>
    <footer class="py-6 text-center text-white/90 text-sm animate-fade-in">
      © All rights reserved by <b>WIS</b>.
    </footer>
  </div>
</template>

<style>

.animate-fade-in-down {
  animation: fade-in-down 0.8s ease-out;
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out;
}

.animate-fade-in {
  animation: fade-in 1s ease-out;
}
</style>