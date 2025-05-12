<template>
  <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-4">
    <div
      v-for="(ods, index) in odsList"
      :key="ods.title"
      class="overflow-hidden rounded-sm shadow-sm transition-all transform hover:shadow-md hover:!scale-105 animate-fadeInUp"
      :style="{ animationDelay: `${0.1 + index * 0.1}s`, backgroundColor: ods.bgColor }"
    >
      <div :class="['h-2', ods.accentBar]"></div>
      <div class="p-4">
        <div class="flex items-start mb-3">
          <div :class="['p-2 rounded-full', ods.iconBg]">
            <img :src="ods.icon" :alt="ods.title" class="w-6 h-6" />
          </div>
        </div>
        <h3 class="mb-1 text-sm font-semibold text-left">{{ ods.title }}</h3>
        <p class="text-xs font-light text-gray-600 text-left">{{ ods.description }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ods2Icon from '@/images/icons/ods2.png?url'
import ods6Icon from '@/images/icons/ods6.png?url'
import ods12Icon from '@/images/icons/ods12.png?url'
import ods13Icon from '@/images/icons/ods13.png?url'
const odsList = ref([
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
])
</script>
