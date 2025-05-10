<script setup>
import OdsCardList from '@/components/landingPage/OdsCardList.vue'
import logotipo from '@/images/logotipo.png?url'
import collage1 from '@/images/collage1.jpg?url'
import collage2 from '@/images/collage2.jpg?url'
import collage3 from '@/images/collage3.jpg?url'
import { useRouter } from 'vue-router'
import { onMounted } from 'vue';

const router = useRouter()

const tabs = ['Características', 'Beneficios', 'Tecnología']
const activeTab = ref('Tecnología')


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
            window.history.replaceState(null, '', window.location.pathicon + window.location.search);
          }
        }
      }
    });
  });
});

</script>


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

    
    <section class="bg-[#e6fdf8] py-10 px-4 md:px-8 font-sans">
      <h2 class="text-center text-2xl font-semibold text-[#008080] mb-8">Sistema Hidropónico Principal</h2>
      <!-- Modern Tabs -->
      <div class="mx-auto max-w-4xl">
        <!-- Tabs Triggers -->
        <div class="grid w-full grid-cols-3 rounded-t-lg overflow-hidden border-b border-[#b3e6dd]">
          <button
            :class="[
              'py-3 font-semibold text-center transition-colors duration-200',
              activeTab === 'Características'
                ? 'bg-white text-[#008080] border-b-2 border-white'
                : 'bg-[#e6fdf8] text-gray-500 hover:text-[#008080]'
            ]"
            @click="activeTab = 'Características'"
          >
            Características
          </button>
          <button
            :class="[
              'py-3 font-semibold text-center transition-colors duration-200',
              activeTab === 'Beneficios'
                ? 'bg-white text-[#008080] border-b-2 border-white'
                : 'bg-[#e6fdf8] text-gray-500 hover:text-[#008080]'
            ]"
            @click="activeTab = 'Beneficios'"
          >
            Beneficios
          </button>
          <button
            :class="[
              'py-3 font-semibold text-center transition-colors duration-200',
              activeTab === 'Tecnología'
                ? 'bg-white text-[#008080] border-b-2 border-white'
                : 'bg-[#e6fdf8] text-gray-500 hover:text-[#008080]'
            ]"
            @click="activeTab = 'Tecnología'"
          >
            Tecnología
          </button>
        </div>
        <!-- Tabs Content -->
        <div v-if="activeTab === 'Características'" class="p-6 mt-2 bg-white rounded-b-lg shadow-md min-h-[370px]">
          <div class="grid gap-8 md:grid-cols-2">
            <div>
              <h3 class="mb-4 text-xl font-bold">Sistema Vertical de Circuito Cerrado</h3>
              <ul class="space-y-3">
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-cyan-500 rounded-full" />
                  <span>Cultivo de hasta 200 plantas en apenas 2m²</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-cyan-500 rounded-full" />
                  <span>Ahorro del 95% de agua vs. cultivos tradicionales</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-cyan-500 rounded-full" />
                  <span>Control automatizado de nutrientes y pH</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-cyan-500 rounded-full" />
                  <span>Monitoreo remoto vía aplicación móvil</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-cyan-500 rounded-full" />
                  <span>Iluminación LED de espectro completo</span>
                </li>
              </ul>
            </div>
            <div class="overflow-hidden relative h-64 rounded-lg">
              <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-cyan-500 rounded-lg opacity-20 animate-pulse"></div>
              <div class="flex absolute inset-0 justify-center items-center">
                <div class="text-center">
                  <div class="mb-2 text-6xl">🌿</div>
                  <p class="font-semibold text-gray-700">Sistema Hidropónico Vertical</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else-if="activeTab === 'Beneficios'" class="p-6 mt-2 bg-white rounded-b-lg shadow-md min-h-[370px]">
          <div class="grid gap-8 md:grid-cols-2">
            <div>
              <h3 class="mb-4 text-xl font-bold">Beneficios Ambientales y Sociales</h3>
              <ul class="space-y-3">
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-green-500 rounded-full" />
                  <span>Reducción del 95% en consumo de agua</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-green-500 rounded-full" />
                  <span>Producción hasta 10 veces mayor por metro cuadrado</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-green-500 rounded-full" />
                  <span>Cultivos libres de pesticidas y herbicidas</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-green-500 rounded-full" />
                  <span>Menor huella de carbono en transporte de alimentos</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-green-500 rounded-full" />
                  <span>Creación de empleos verdes en comunidades urbanas</span>
                </li>
              </ul>
            </div>
            <div class="p-6 bg-green-50 rounded-lg">
              <h3 class="mb-4 text-xl font-bold text-green-700">Impacto Medioambiental</h3>
              <div class="space-y-4">
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium">Ahorro de agua</span>
                    <span class="text-sm font-medium">95%</span>
                  </div>
                  <div class="w-full h-2.5 bg-gray-200 rounded-full">
                    <div class="h-2.5 bg-green-600 rounded-full" style="width: 95%"></div>
                  </div>
                </div>
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium">Reducción de espacio</span>
                    <span class="text-sm font-medium">90%</span>
                  </div>
                  <div class="w-full h-2.5 bg-gray-200 rounded-full">
                    <div class="h-2.5 bg-green-600 rounded-full" style="width: 90%"></div>
                  </div>
                </div>
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium">Reducción de CO₂</span>
                    <span class="text-sm font-medium">70%</span>
                  </div>
                  <div class="w-full h-2.5 bg-gray-200 rounded-full">
                    <div class="h-2.5 bg-green-600 rounded-full" style="width: 70%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else-if="activeTab === 'Tecnología'" class="p-6 mt-2 bg-white rounded-b-lg shadow-md min-h-[370px]">
          <div class="grid gap-8 md:grid-cols-2">
            <div>
              <h3 class="mb-4 text-xl font-bold">Tecnología Avanzada</h3>
              <ul class="space-y-3">
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-blue-500 rounded-full" />
                  <span>Sensores IoT para monitoreo en tiempo real</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-blue-500 rounded-full" />
                  <span>Algoritmos de IA para optimización de nutrientes</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-blue-500 rounded-full" />
                  <span>Sistema de recirculación de agua de alta eficiencia</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-blue-500 rounded-full" />
                  <span>Paneles solares integrados para autonomía energética</span>
                </li>
                <li class="flex items-start">
                  <VIcon icon="bx-check" class="p-2 mt-1 mr-2 text-xs text-white bg-blue-500 rounded-full" />
                  <span>Aplicación móvil con alertas y recomendaciones</span>
                </li>
              </ul>
            </div>
            <div class="p-6 bg-blue-50 rounded-lg">
              <h3 class="mb-4 text-xl font-bold text-blue-700">Componentes del Sistema</h3>
              <div class="space-y-4">
                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                  <div class="flex justify-center items-center mr-3 w-10 h-10 text-xl bg-blue-100 rounded-full">
                    💧
                  </div>
                  <div>
                    <h4 class="font-medium">Sistema de Nutrición</h4>
                    <p class="text-sm text-gray-600">Dosificación automatizada de nutrientes</p>
                  </div>
                </div>
                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                  <div class="flex justify-center items-center mr-3 w-10 h-10 text-xl bg-blue-100 rounded-full">
                    💡
                  </div>
                  <div>
                    <h4 class="font-medium">Iluminación LED</h4>
                    <p class="text-sm text-gray-600">Espectro completo ajustable según cultivo</p>
                  </div>
                </div>
                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                  <div class="flex justify-center items-center mr-3 w-10 h-10 text-xl bg-blue-100 rounded-full">
                    📱
                  </div>
                  <div>
                    <h4 class="font-medium">Control Remoto</h4>
                    <p class="text-sm text-gray-600">Monitoreo y ajustes desde cualquier lugar</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

  <!-- Footer -->
  <footer class="bg-[#e0fcf8] pt-8 pb-0 border-t border-[#b3e6dd] mt-12">
    <div class="container px-4 mx-auto">
      <div class="flex flex-col gap-8 justify-between items-start pb-2 md:flex-row md:items-center">
        <!-- Columna 1: Logo y descripción -->
        <div class="flex-1 flex items-start gap-3 min-w-[200px]">
          <img :src="logotipo" alt="AQUANOVA Logo" class="object-contain mt-1 w-16 h-12" />
          <p class="text-[#226666] text-sm leading-snug mt-1">
            Innovación hidropónica para un futuro sostenible. Abordamos 4 ODS con tecnología de vanguardia.
          </p>
        </div>
        <!-- Columna 2: Contacto -->
        <div class="flex-1 min-w-[220px]">
          <h3 class="text-[#008080] font-semibold mb-1 text-lg">Contacto</h3>
          <ul class="text-[#226666] text-sm space-y-1">
            <li class="flex gap-2 items-center">
              <span class="text-base align-middle material-icons">email</span>
              aquanovaproject@gmail.com
            </li>
            <li class="flex gap-2 items-center">
              <span class="text-base align-middle material-icons">phone</span>
              +52 314 103 7075
            </li>
            <li class="flex gap-2 items-center">
              <span class="text-base align-middle material-icons">Ubicados en</span>
              Manzanillo, Colima
            </li>
          </ul>
        </div>
        <!-- Columna 3: Suscripción -->
        <div class="flex-1 min-w-[220px]">
          <h3 class="text-[#008080] font-semibold mb-1 text-lg text-right md:text-left">Suscríbete</h3>
          <p class="text-[#226666] text-xs italic text-right md:text-left mb-2">Recibe noticias y actualizaciones<br>sobre nuestros proyectos</p>
          <form class="flex gap-2 justify-end items-center md:justify-start">
            <input type="email" placeholder="Tu correo" class="px-2 py-1 w-32 text-sm rounded border border-black md:w-36 focus:outline-none" />
            <button type="submit" class="border border-black px-3 py-1 rounded bg-white hover:bg-[#d3f8f2] text-sm font-semibold">Enviar</button>
          </form>
        </div>
      </div>
    </div>
    <div class="border-t border-[#b3e6dd] mt-4">
      <p class="text-center text-[#226666] text-xs py-2">© 2025 AquaNova. Todos los derechos reservados.</p>
    </div>
  </footer>
</template>

