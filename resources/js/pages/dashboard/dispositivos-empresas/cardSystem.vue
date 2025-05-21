<script setup>
import { ref, computed, onMounted } from 'vue'
import PHImage from '@images/sensors/PH.png?url'
import CEImage from '@images/sensors/CE.png?url'
import DHT11 from '@images/sensors/DHT11.png?url'
import TempImage from '@images/sensors/Temp.png?url'
import DistImage from '@images/sensors/Dist.png?url'
import useAllDevices  from '@/hooks/devicesSistems/useGetDevices'
import useToggleDevice from '@/hooks/devicesSistems/useToggleDevice'  

const props = defineProps({
  sistema: Object,
  expandedId: Number,
})


const expandedSistemaId = ref(null)

const isExpanded = computed(() => expandedSistemaId.value === props.sistema.id)

const { dispositivos, loadAllDevices, first, loading } = useAllDevices()

const { toggleDevice, currentDevice, loading: loadingToggle } = useToggleDevice()

const sensorForImages = {
  1: CEImage,
  2: PHImage,
  3: DHT11,
  4: TempImage,
  5: DistImage,
}

function toggleDeviceList() {
  expandedSistemaId.value = isExpanded.value ? null : props.sistema.id
  if (isExpanded.value) {
    console.log(props.sistema.id)
    loadAllDevices(props.sistema.id_empresa)
  }
}
</script>

<template>
  <VCard
    class="overflow-hidden rounded-2xl border border-gray-200 shadow-md transition-all hover:shadow-lg"
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
        <VIcon v-if="!loading || !first" :icon="isExpanded ? 'bx-chevron-up' : 'bx-chevron-down'" class="transition-transform" />
        <LoadingIcon v-else icon="tail-spin" class="w-6 h-6" />
      </div>

      <Transition name="fade-slide">
        <div
          v-if="isExpanded"
          class="border-t border-gray-200 divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700"
        >
          <div
            v-for="device in dispositivos"
            v-if="!loading || !first"
            :key="device.id_dispositivo"
            class="flex justify-between items-center p-4"
          >
            <div class="flex gap-3 items-center">
              <VImg
                :src="sensorForImages[device.id_dispositivo]"
                alt="Sensor Image"
                class="object-contain w-12 h-12 bg-white rounded-lg border border-gray-300 dark:border-gray-600"
              />
              <div>
                <h4 class="text-sm font-medium text-gray-800 dark:text-white">{{ device.nombre }}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ device.descripcion }}</p>
              </div>
            </div>

            <VSwitch
              :disabled="currentDevice == device.id_dispositivo"
              v-model="device.enabled"
              @change="toggleDevice(props.sistema.id_empresa, device.id_dispositivo)"
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
