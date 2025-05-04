<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth' });
          // Evita que el #id aparezca en la URL
          if (window.history.replaceState) {
            window.history.replaceState(null, '', window.location.pathname + window.location.search);
          }
        }
      }
    });
  });
});

// scrollbar-aqua
</script>

<template>
  <div class="min-h-screen w-full bg-gradient-to-tr from-[#97DFDB]/80 to-[#21797A]/90 flex flex-col items-center relative">
    <!-- Botón discreto de login -->
    <a href="/login" class="absolute top-4 right-6 text-white bg-[#4ca4a5] hover:bg-[#2da3a5] rounded-full px-4 py-1 text-sm opacity-50 hover:opacity-100 transition transform hover:scale-105 hover:text-white font-bold focus:outline-none z-10">Iniciar sesión</a>
    <!-- Hero Section -->
    <section class="flex flex-col justify-center items-center px-4 py-16 w-full h-screen text-center">
      <img src="/logo-white.png" alt="Logo AquaNova" class="object-cover mx-auto mb-6 w-[250px] h-[250px] animate-scale-in" />
      <h2 class="mb-4 text-2xl italic font-bold text-white drop-shadow-lg md:text-4xl">Innovación que fluye como el agua</h2>
      <p class="text-xl md:text-2xl text-[#96f1f3] font-medium mb-6 max-w-2xl mx-auto">
        Hidroponía automatizada para un futuro sostenible.<br>
        Cultiva más, usando menos recursos, con tecnología accesible y eficiente.
      </p>
      <a href="#porque" class="inline-block bg-[#5ac0c2] hover:bg-[#2da3a5] text-white font-bold px-8 py-3 rounded-full shadow-lg text-lg transform hover:scale-105 transition-all duration-300">Descubre el proyecto</a>
    </section>

    <!-- ¿Por qué AquaNova? -->
    <section id="porque" class="px-4 py-12 w-full max-w-5xl">
      <div class="grid gap-10 items-center md:grid-cols-2">
        <div alt="Imagen Hidroponía" class="rounded-xl shadow-lg w-full h-[30rem] overflow-hidden  bg-[#97DFDB]">
          <img src="/landing/maquetado.png" alt="Imagen Hidroponía" class="object-cover w-full h-full transition-all duration-300 transform hover:scale-110" />
        </div>
        <div>
          <h2 class="mb-4 text-3xl font-bold text-white">¿Por qué AquaNova?</h2>
          <ul class="mb-4 space-y-2 text-lg text-white">
            <li><span class="font-bold">90% menos agua</span> que agricultura tradicional.</li>
            <li><span class="font-bold">Sin pesticidas</span> y <span class="font-bold">mayor productividad</span>.</li>
            <li>Automatización accesible para todos.</li>
            <li>Solución escalable y modular.</li>
          </ul>
          <div class="flex flex-wrap gap-3">
            <span class="bg-[#70b9bb] text-white px-3 py-1 rounded-full font-semibold text-sm">NFT</span>
            <span class="bg-[#70b9bb] text-white px-3 py-1 rounded-full font-semibold text-sm">Raspberry Pi 4</span>
            <span class="bg-[#70b9bb] text-white px-3 py-1 rounded-full font-semibold text-sm">Sensores IoT</span>
            <span class="bg-[#70b9bb] text-white px-3 py-1 rounded-full font-semibold text-sm">Automatización</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Objetivos y ODS -->
    <section class="grid gap-10 items-center px-4 py-12 w-full max-w-5xl md:grid-cols-2">
      <div>
        <h2 class="mb-4 text-3xl font-bold text-white">Objetivos del Proyecto</h2>
        <ul class="pl-6 space-y-2 text-lg list-disc text-white">
          <li>Monitorear y controlar <span class="font-bold">pH, temperatura, humedad y nutrientes</span> en tiempo real.</li>
          <li>Optimizar el uso del agua y recursos.</li>
          <li>Facilitar la adopción de hidroponía en el hogar y pequeños productores.</li>
          <li>Promover prácticas agrícolas sostenibles y eficientes.</li>
        </ul>
      </div>
      <div>
        <h3 class="mb-2 text-2xl font-bold text-white">Alineado a los ODS</h3>
        <div class="flex flex-wrap gap-3">
          <span class="bg-[#52c4b9] text-[#0a6b76] px-4 py-2 rounded-xl font-semibold text-base shadow">ODS 2: Hambre Cero</span>
          <span class="bg-[#a0e1d0] text-[#1aa1a4] px-4 py-2 rounded-xl font-semibold text-base shadow">ODS 6: Agua limpia</span>
          <span class="bg-[#0a6c76] text-[#a4e3d3] px-4 py-2 rounded-xl font-semibold text-base shadow">ODS 9: Innovación</span>
          <span class="bg-[#189fa2] text-[#c2ebdb] px-4 py-2 rounded-xl font-semibold text-base shadow">ODS 12: Consumo Responsable</span>
        </div>
        <div class="rounded-xl shadow-lg w-full h-[29rem] overflow-hidden  bg-[#97DFDB] mt-6">
          <img src="/landing/ods.png" alt="ODS Illustration" class="object-cover w-full h-full transition-all duration-300 transform hover:scale-110" />
        </div>
      </div>
    </section>

    <!-- Tecnologías -->
    <section class="px-4 py-12 w-full max-w-5xl">
      <h2 class="mb-8 text-3xl font-bold text-center text-white">Tecnologías Clave</h2>
      <div class="grid gap-8 md:grid-cols-3">
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="/landing/raspberry.png" alt="Raspberry Pi" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">Raspberry Pi 4</h3>
          <p class="text-[#4CA4A5] text-center">Unidad de control central, procesamiento en tiempo real y conectividad.</p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="/landing/arduino.png" alt="Arduino" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">Arduino</h3>
          <p class="text-[#4CA4A5] text-center">Lectura precisa de sensores y control de actuadores.</p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="/landing/sensores.png" alt="Sensores" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">Sensores IoT</h3>
          <p class="text-[#4CA4A5] text-center">Monitoreo ambiental: pH, temperatura, humedad, conductividad y nivel de agua.</p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="" alt="Express.js" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">Express.js</h3>
          <p class="text-[#4CA4A5] text-center">API eficiente para comunicación y almacenamiento de datos.</p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="" alt="PyQt" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">PyQt</h3>
          <p class="text-[#4CA4A5] text-center">Interfaz gráfica moderna para monitoreo y control.</p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-xl shadow-lg bg-white/90">
          <img src="" alt="Firebase & SQLite" class="object-contain mb-4 w-16 h-16" />
          <h3 class="mb-2 text-xl font-bold text-[#4CA4A5]">Firebase & SQLite</h3>
          <p class="text-[#4CA4A5] text-center">Almacenamiento local y en la nube, sincronización en tiempo real.</p>
        </div>
      </div>
    </section>

    <!-- Equipo -->
    <section class="px-4 py-12 w-full max-w-5xl">
      <h2 class="mb-8 text-3xl font-bold text-center text-white">Equipo de Desarrollo</h2>
      <div class="grid gap-6 md:grid-cols-3">
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 1" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Arcega Rodríguez Eduardo</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 2" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Cabanillas Galván Ricardo</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 3" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Cabrales López Annelise Najara</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 4" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Cruz Villanueva Daniel</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 5" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Enríquez Tinoco Jesús Antonio</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 6" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Medina López Brisa Cristal</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 7" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Ballinas Arteaga Jesús Emilio</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 8" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Martínez Vargas Juan Pablo</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 9" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Navarro Álvarez Ernesto</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 10" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Rosales Busquets Enrique Carlos</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 11" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Santana Moreno Ana Magaly</span>
        </div>
        <div class="bg-[#97DFDB]/80 rounded-xl shadow p-4 flex flex-col items-center">
          <img src="" alt="Integrante 12" class="w-16 h-16 rounded-full object-cover mb-2 bg-[#70B9BB]" />
          <span class="font-semibold text-white">Verde Romero Daniel Alfonso</span>
        </div>
      </div>
      <div class="mt-8 text-center text-[#4CA4A5] text-lg font-semibold">
        Facultad de Ingeniería Electromecánica (FIE), Manzanillo, Colima<br/>
        Ingeniería de Software, 4° Semestre, Grupo “E”<br/>
        <span class="text-white">Abril 2025</span>
      </div>
    </section>

    <!-- Footer / CTA -->
    <footer class="w-full py-10 px-4 bg-[#21797A] text-white text-center mt-8">
      <h3 class="mb-2 text-2xl font-extrabold md:text-3xl">¿Listo para cultivar el futuro?</h3>
      <p class="mb-4 text-lg">Descubre cómo AquaNova puede transformar tu manera de producir alimentos.</p>
      <a href="#" class="inline-block bg-[#97DFDB] hover:bg-[#4CA4A5] text-white font-bold px-8 py-3 rounded-full shadow-lg transition-all text-lg">Contáctanos</a>
      <div class="mt-6 text-sm text-[#97DFDB]">&copy; 2025 AquaNova. Todos los derechos reservados.</div>
    </footer>
  </div>
</template>
