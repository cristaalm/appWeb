<template>
  <div class="min-h-screen font-poppins">
    <!-- Sección superior -->
    <div class="bg-[#e0f7f2]">
      <!-- Header -->
      <header class="flex flex-col md:flex-row justify-between items-center px-4 md:px-6 py-3 border-b border-red-500">
        <div class="flex items-center gap-2 mb-4 md:mb-0">
          <img :src="logotipo" alt="AQUANOVA Logo" class="h-8 w-auto" />
          <span class="text-[#008080] font-extrabold text-xl">AQUANOVA</span>
        </div>
        <nav class="flex flex-wrap justify-center space-x-4 mb-4 md:mb-0">
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Inicio</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Hidroponía</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Proyecto</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">ODS</a>
          <a href="#" class="text-[#008080] hover:text-[#005050] transition-colors duration-300 text-sm font-medium relative nav-link">Equipo</a>
        </nav>
        <button class="bg-[#008080] text-white px-4 py-1 rounded text-sm hover:bg-[#006666] transition-colors duration-300 transform hover:scale-105">
          Iniciar sesión
        </button>
      </header>

      <!-- Hero Section -->
      <section class="container mx-auto px-4 md:px-6 py-6 md:py-10 animate-fadeIn">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
          <div class="relative h-64 md:h-80 mt-4 md:mt-0 animate-fadeIn" style="animation-delay: 0.5s">
            <div class="absolute top-6 left-0 w-3/5 h-2/3 z-10 transform hover:scale-105 transition-transform duration-300 rotate-[-5deg] shadow-md">
              <img :src="collage1" alt="Imag1" class="w-full h-full object-cover border-2 border-white" />
            </div>
            <div class="absolute top-0 right-4 w-2/4 h-1/2 z-20 transform hover:scale-105 transition-transform duration-300 rotate-[3deg] shadow-md">
              <img :src="collage2" alt="Imag2" class="w-full h-full object-cover border-2 border-white" />
            </div>
            <div class="absolute bottom-4 left-8 w-2/3 h-1/2 z-30 transform hover:scale-105 transition-transform duration-300 rotate-[5deg] shadow-md">
              <img :src="collage3" alt="Imag3" class="w-full h-full object-cover border-2 border-white" />
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Sección ODS -->
    <div class="bg-[#f0fcfa]">
      <section class="container mx-auto px-4 md:px-6 py-8">
        <h2 class="text-xl font-bold text-center text-gray-800 mb-6 md:mb-8 animate-fadeIn">
          Nuestros Objetivos de Desarrollo Sostenible
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div
            v-for="(ods, index) in odsList"
            :key="ods.title"
            class="rounded-sm overflow-hidden shadow-sm hover:shadow-md transition-shadow transform hover:-translate-y-1 animate-fadeInUp"
            :style="{ animationDelay: `${0.1 + index * 0.1}s`, backgroundColor: ods.bgColor }"
          >
            <div :class="['h-2', ods.accentBar]"></div>
            <div class="p-4">
              <div class="flex justify-center mb-3">
                <div :class="['p-2 rounded-full', ods.iconBg]">
                  <img :src="ods.icon" :alt="ods.title" class="h-6 w-6" />
                </div>
              </div>
              <h3 class="font-semibold text-center text-sm mb-1">{{ ods.title }}</h3>
              <p class="text-xs text-gray-600 font-light">{{ ods.description }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import logotipo from '@/images/logotipo.png'
import collage1 from '@/images/collage1.jpg'
import collage2 from '@/images/collage2.jpg'
import collage3 from '@/images/collage3.jpg'
import ods2Icon from '@/images/icons/ods2.png'
import ods6Icon from '@/images/icons/ods6.png'
import ods12Icon from '@/images/icons/ods12.png'
import ods13Icon from '@/images/icons/ods13.png'

export default {
  name: 'AquanovaApp',
  data() {
    return {
      logotipo,
      collage1,
      collage2,
      collage3,
      ods2Icon,
      ods6Icon,
      ods12Icon,
      ods13Icon,
      odsList: [
        {
          title: 'ODS 2: Hambre Cero',
          description: 'Promueve sistemas alimentarios con producción local, eficiente y sostenible de alimentos.',
          icon: ods2Icon,
          bgColor: '#fff8f0',
          iconBg: 'bg-[#ffebcc]',
          accentBar: 'bg-[#ff8c00]'
        },
        {
          title: 'ODS 6: Agua Limpia y Saneamiento',
          description: 'Usa hasta 90% menos agua que la agricultura tradicional mediante recirculación y control.',
          icon: ods6Icon,
          bgColor: '#f0f8ff',
          iconBg: 'bg-[#cce6ff]',
          accentBar: 'bg-[#1e90ff]'
        },
        {
          title: 'ODS 12: Producción y consumo responsables',
          description: 'Fomenta el uso eficiente de recursos y reduce residuos y químicos nocivos.',
          icon: ods12Icon,
          bgColor: '#f0fff0',
          iconBg: 'bg-[#ccffcc]',
          accentBar: 'bg-[#32cd32]'
        },
        {
          title: 'ODS 13: Acción Climática',
          description: 'Disminuye emisiones al promover cultivos locales y sistemas más sostenibles.',
          icon: ods13Icon,
          bgColor: '#faf0ff',
          iconBg: 'bg-[#e6ccff]',
          accentBar: 'bg-[#9932cc]'
        }
      ]
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;700;800;900&display=swap');

.font-poppins {
  font-family: 'Poppins', sans-serif;
}

.animate-fadeIn {
  animation: fadeIn 1s ease-in-out;
}

.animate-fadeInUp {
  animation: fadeInUp 0.8s ease-out forwards;
}

.animate-slideInLeft {
  animation: slideInLeft 0.8s ease-out forwards;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
  from { opacity: 0; transform: translateX(-20px); }
  to { opacity: 1; transform: translateX(0); }
}

.nav-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: -2px;
  left: 0;
  background-color: #008080;
  transition: width 0.3s ease;
}

.nav-link:hover::after {
  width: 100%;
}

@media (max-width: 640px) {
  .container {
    width: 100%;
    padding-left: 1rem;
    padding-right: 1rem;
  }
}
</style>
