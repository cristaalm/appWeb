<script setup>
import OdsCardList from '@/components/landingPage/OdsCardList.vue'
import logotipo from '@/images/logotipo.png?url'
import collage1 from '@/images/collage1.jpg?url'
import collage2 from '@/images/collage2.jpg?url'
import collage3 from '@/images/collage3.jpg?url'
import { useRouter } from 'vue-router'
import { onMounted } from 'vue';

const router = useRouter()


onMounted(() => {
  // Scroll smooth - Scroll Suave
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth' });
          if (window.history.replaceState) {
            window.history.replaceState(null, '', window.location.pathname + window.location.search);
          }
        }
      }
    });
  });
});

</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;700;800;900&display=swap');
</style>

<template>
  <div class="min-h-screen font-poppins">
    <!-- Sección superior -->
    <div class="bg-[#e0f7f2]">
      <!-- Header -->
      <header class="flex flex-col justify-between items-center px-4 py-3 border-b border-red-500 md:flex-row md:px-6">
        <div class="flex gap-2 items-center mb-4 md:mb-0">
          <img :src="logotipo" alt="AQUANOVA Logo" class="w-auto h-8" />
          <span class="text-[#008080] font-extrabold text-xl">AQUANOVA</span>
        </div>
        <nav class="flex flex-wrap justify-center mb-4 space-x-4 md:mb-0">
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Inicio</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Hidroponía</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Proyecto</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">ODS</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Equipo</a>
        </nav>
        <button @click="router.push('/login')" class="bg-[#008080] text-white px-4 py-1 rounded text-sm hover:bg-[#006666] transition-colors duration-300 transform hover:scale-105">
          Iniciar sesión
        </button>
      </header>

      <!-- Hero Section -->
      <section class="container px-4 py-6 mx-auto md:px-6 md:py-10 animate-fadeIn">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
          <div class="flex flex-col justify-center space-y-4 h-full">
            <h2 class="text-2xl md:text-3xl font-bold text-[#008080] animate-slideInLeft">
              Innovación Hidropónica<br />para un Futuro Sostenible
            </h2>
            <p class="text-[#008080] text-sm max-w-md font-light animate-slideInLeft" style="animation-delay: 0.2s">
              Plataforma educativa y de gestión sobre el agua y saneamiento para un futuro sostenible
            </p>
            <div class="flex gap-3 animate-slideInLeft" style="animation-delay: 0.4s">
              <button class="bg-[#008080] text-white px-4 py-1 rounded text-sm border border-[#008080] hover:bg-[#006666] transition-all duration-300 transform hover:scale-105">
                Explorar proyecto
              </button>
              <button class="bg-white text-[#008080] px-4 py-1 rounded text-sm border border-[#008080] hover:bg-[#e0f7f2] transition-all duration-300 transform hover:scale-105">
                Sobre nosotros
              </button>
            </div>
          </div>
          <div class="relative mt-4 h-64 md:h-80 md:mt-0 animate-fadeIn" style="animation-delay: 0.5s">
            <div class="absolute top-6 left-0 w-3/5 h-2/3 z-10 transform hover:scale-105 transition-transform duration-300 rotate-[-5deg] shadow-md">
              <img :src="collage1" alt="Imag1" class="object-cover w-full h-full border-2 border-white" />
            </div>
            <div class="absolute top-0 right-4 w-2/4 h-1/2 z-20 transform hover:scale-105 transition-transform duration-300 rotate-[3deg] shadow-md">
              <img :src="collage2" alt="Imag2" class="object-cover w-full h-full border-2 border-white" />
            </div>
            <div class="absolute bottom-4 left-8 w-2/3 h-1/2 z-30 transform hover:scale-105 transition-transform duration-300 rotate-[5deg] shadow-md">
              <img :src="collage3" alt="Imag3" class="object-cover w-full h-full border-2 border-white" />
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Sección ODS -->
    <div class="bg-[#f0fcfa]">
      <section class="container px-4 py-8 mx-auto md:px-6">
        <h2 class="mb-6 text-xl font-bold text-center text-gray-800 md:mb-8 animate-fadeIn">
          Nuestros Objetivos de Desarrollo Sostenible
        </h2>
        <OdsCardList />
      </section>
    </div>
  </div>
</template>
