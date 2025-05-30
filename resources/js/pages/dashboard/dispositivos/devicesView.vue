<script setup>
import { ref, inject } from 'vue'
import LoadingIcon from '@/components/Base/LoadingIcon'
import PHImage from '@images/sensors/PH.png?url'
import CEImage from '@images/sensors/CE.png?url'
import DHT11 from '@images/sensors/DHT11.png?url'
import TempImage from '@images/sensors/Temp.png?url'
import DistImage from '@images/sensors/Dist.png?url'
import DeviceDetailsForm from './deviceDetailsForm'

const selectedDevice = ref(null)

const devices = [
  { 
    id_dispositivo: 1, 
    nombre: 'Sensor de conductividad eléctrica', 
    descripcion: 'Mide la conductividad eléctrica de un fluido',
    min: 0,
    max: 9999,
    campos: [
      {
        label: 'Tiempo batido (seg)',
        name: 'tiempo_batido',
        slider: "normal",
        type: 'number',
        required: true,
      },
      {
        label: 'Conductividad (ppm)',
        name: 'conductividad',
        type: 'decimal',
        slider: "range",
        required: true,
      },
    ]
  },
  { 
    id_dispositivo: 2, 
    nombre: 'Sensor de pH', 
    descripcion: 'Mide la concentración de átomos hidrogenoiones en un fluido',
    min: 0,
    max: 14,
    campos: [
      {
        label: 'Tiempo batido (seg)',
        name: 'tiempo_batido',
        slider: "normal",
        type: 'number',
        required: true,
      },
      {
        label: 'pH',
        name: 'ph',
        type: 'decimal',
        slider: "range",
        required: true,
      },
    ]
  },
  { 
    id_dispositivo: 3, 
    nombre: 'Sensor de humedad y temperatura', 
    descripcion: 'Mide la humedad relativa y la temperatura en un ambiente',
    min: 0,
    max: 100,
    campos: [
      {
        label: 'Humedad (%)',
        name: 'humedadDHT11',
        type: 'number',
        slider: "range",
        required: true,
      },
      {
        label: 'Temperatura (°C)',
        name: 'temperaturaDHT11',
        type: 'decimal',
        slider: "range",
        required: true,
      },
    ]
  },
  { 
    id_dispositivo: 4, 
    nombre: 'Sensor de temperatura', 
    descripcion: 'Mide la temperatura en un ambiente',
    min: 0,
    max: 100,
    campos: [
      {
        label: 'Temperatura (°C)',
        name: 'temperatura',
        type: 'decimal',
        slider: "range",
        required: true,
      },
    ] 
  },
  { 
    id_dispositivo: 5, 
    nombre: 'Sensor de distancia', 
    descripcion: 'Mide la distancia entre dos objetos',
    min: 0,
    max: 100,
    campos: [
      {
        label: 'Distancia (cm)',
        name: 'distancia',
        type: 'number',
        slider: "range",
        required: true,
      },
    ] 
  },
]

const { devices: devicesInfo, loading, error, first, loadAllDevices } = inject('devices')

const sensorForImages = {
  1: CEImage,
  2: PHImage,
  3: DHT11,
  4: TempImage,
  5: DistImage,
}

function selectDevice(device) {
  selectedDevice.value = device
}

function goBack() {
  selectedDevice.value = null
}

onMounted(() => {
    loadAllDevices()
})
</script>

<template>
  <div class="py-6 w-full">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold tracking-tight">Gestión de Dispositivos</h1>
      <p class="mt-1 text-muted-foreground">Administra los dispositivos disponibles</p>
    </div>

    <div class="grid grid-cols-12 gap-6 min-h-[calc(100vh-400px)] overflow-y-auto">
      
      <!-- 📱/💻 Contenedor Lista -->
      <div
        :class="[
          'col-span-12 md:col-span-6 xl:col-span-5 2xl:col-span-4 bg-white dark:bg-[var(--dark-dashboard)] rounded-lg shadow max-h-[calc(100vh-200px)]',
          selectedDevice ? 'hidden md:block' : 'block'
        ]"
      >
        <div
          v-for="device in devices"
          :key="device.id_dispositivo"
          :class="['flex gap-4 items-center px-4 py-3 border-b border-gray-200 transition-colors last:border-b-0 dark:border-gray-700',
            loading ? '' : 'hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer'
          ]"
          @click="!loading && selectDevice(device)"
        >
          <img
            :src="sensorForImages[device.id_dispositivo]"
            alt="Sensor Image"
            class="object-contain mx-auto w-28 h-28 bg-white rounded-lg border border-gray-300 sm:w-14 sm:h-14 dark:border-gray-600"
          />

          <div class="flex flex-col flex-1 justify-between min-w-0">
            <h3 class="text-base font-semibold text-gray-900 truncate dark:text-white">
              {{ device.nombre }}
            </h3>
            <p class="text-sm text-gray-500 truncate dark:text-gray-400 text-wrap">
              {{ device.descripcion }}
            </p>
          </div>

          <div class="flex flex-col flex-1 justify-between max-w-12">
            <LoadingIcon v-if="loading" icon="tail-spin" />
          </div>
        </div>
      </div>

      <!-- 📱/💻 Contenedor Detalle -->
      <DeviceDetailsForm
        :selectedDevice="selectedDevice"
        :devicesInfo="devicesInfo"
        @goBack="goBack"
      />


    </div>
  </div>
</template>
