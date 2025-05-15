<script setup>
import { ref, computed } from 'vue'
import PHImage from '@images/sensors/PH.png?url'
import CEImage from '@images/sensors/CE.png?url'
import DHT11 from '@images/sensors/DHT11.png?url'
import TempImage from '@images/sensors/Temp.png?url'
import DistImage from '@images/sensors/Dist.png?url'

const props = defineProps({
  sistema: Object,
  expandedId: Number,
})
const emit = defineEmits(['update-expanded'])

const isExpanded = computed(() => props.expandedId === props.sistema.id)

const devices = ref([
  { id_dispositivo: 1, nombre: 'Sensor de conductividad eléctrica', descripcion: 'Mide la conductividad eléctrica de un fluido', enabled: true },
  { id_dispositivo: 2, nombre: 'Sensor de pH', descripcion: 'Mide la concentración de átomos hidrogenoiones en un fluido', enabled: false },
  { id_dispositivo: 3, nombre: 'Sensor de humedad y temperatura', descripcion: 'Mide la humedad relativa y la temperatura en un ambiente', enabled: true },
  { id_dispositivo: 4, nombre: 'Sensor de temperatura', descripcion: 'Mide la temperatura en un ambiente', enabled: true },
  { id_dispositivo: 5, nombre: 'Sensor de distancia', descripcion: 'Mide la distancia entre dos objetos', enabled: false },
])

const sensorForImages = {
  1: CEImage,
  2: PHImage,
  3: DHT11,
  4: TempImage,
  5: DistImage,
}

function toggleDeviceList() {
  emit('update-expanded', isExpanded.value ? null : props.sistema.id)
}
</script>

<template>
  <VCard
    class="rounded-2xl border border-gray-200 shadow-md transition-all hover:shadow-lg overflow-hidden"
    :class="!sistema.estado ? 'opacity-60 grayscale' : ''"
  >
    <VCardText class="flex gap-4 items-center p-6 pb-4">
      <VAvatar size="64" class="border border-gray-300">
        <VImg :src="sistema.logotipo || '/images/placeholderImage.jpg'" alt="Logo" cover />
      </VAvatar>
      
      <div class="flex-1 min-w-0">
        <h3 class="text-lg font-semibold truncate">{{ sistema.nombre_comercial }}</h3>
        <p class="text-sm text-gray-500 truncate dark:text-slate-300">{{ sistema.razon_social }}</p>
      </div>
    </VCardText>

    <VDivider />

    <div>
      <div
        class="flex justify-between px-6 py-3 bg-[#e8f4f4] dark:bg-theme-1/50 dark:text-white cursor-pointer"
        @click="toggleDeviceList"
      >
        <span class="text-sm font-medium text-gray-700 dark:text-white">Dispositivos</span>
        <VIcon :icon="isExpanded ? 'bx-chevron-up' : 'bx-chevron-down'" class="transition-transform" />
      </div>

      <Transition name="fade-slide">
        <div
          v-if="isExpanded"
          class="border-t border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700"
        >
          <div
            v-for="device in devices"
            :key="device.id_dispositivo"
            class="flex items-center justify-between p-4"
          >
            <div class="flex items-center gap-3">
              <VImg
                :src="sensorForImages[device.id_dispositivo]"
                alt="Sensor Image"
                class="w-12 h-12 bg-white rounded-lg border border-gray-300 dark:border-gray-600 object-contain"
              />
              <div>
                <h4 class="text-sm font-medium text-gray-800 dark:text-white">{{ device.nombre }}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ device.descripcion }}</p>
              </div>
            </div>

            <VSwitch
              v-model="device.enabled"
              hide-details
              inset
            />
          </div>
        </div>
      </Transition>
    </div>
  </VCard>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>