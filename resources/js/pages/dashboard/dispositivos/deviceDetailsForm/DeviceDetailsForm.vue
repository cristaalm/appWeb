<script setup>
import { ref, watch, computed } from 'vue'
import PHImage from '@images/sensors/PH.png?url'
import CEImage from '@images/sensors/CE.png?url'
import DHT11 from '@images/sensors/DHT11.png?url'
import TempImage from '@images/sensors/Temp.png?url'
import DistImage from '@images/sensors/Dist.png?url'
import useUpdateDevice from '@/hooks/Devices/useUpdateDevice'

const props = defineProps({
  selectedDevice: Object,
  devicesInfo: Array
})

const { loading, error, first, updateDevice } = useUpdateDevice()

const sensorForImages = {
  1: CEImage,
  2: PHImage,
  3: DHT11,
  4: TempImage,
  5: DistImage,
}

const emits = defineEmits(['save', 'goBack'])

const localValues = ref({})

watch(
  () => props.selectedDevice,
  (newDevice) => {
    if (!newDevice) return

    const values = {}

    // Buscar el dispositivo correspondiente en devicesInfo
    const deviceFromDB = props.devicesInfo.find(
      (dev) => dev.id_dispositivo === newDevice.id_dispositivo
    )

    if (newDevice?.campos) {
      for (const campo of newDevice.campos) {
        // Intentamos obtener el valor desde la base de datos
        // let valorDesdeDB = deviceFromDB?.[campo.name]
        let valorDesdeDB = null
        if (campo.name == 'tiempo_batido'){
          valorDesdeDB = deviceFromDB?.tiempo_batido ?? 0
        } else if (campo.name == 'humedadDHT11') {
          const deviceInfo = props.devicesInfo.find((dev) => dev.id_dispositivo == 3)
          let min = deviceInfo?.valor_minimo ?? 0
          let max = deviceInfo?.valor_maximo ?? 100
          valorDesdeDB = [min, max]
          values[campo.name] = valorDesdeDB
          continue
        } else if (campo.name == 'temperaturaDHT11') {
          const deviceInfo = props.devicesInfo.find((dev) => dev.id_dispositivo == 6)
          let min = deviceInfo?.valor_minimo ?? 0
          let max = deviceInfo?.valor_maximo ?? 100
          valorDesdeDB = [min, max]
          values[campo.name] = valorDesdeDB
          continue
        } else {
          const min = deviceFromDB?.valor_minimo ?? 0
          const max = deviceFromDB?.valor_maximo ?? 100
          valorDesdeDB = [min, max]
        }
        // Si existe, lo usamos; si no, usamos lo que venga en selectedDevice; si tampoco, null
        values[campo.name] = valorDesdeDB ?? newDevice[campo.name] ?? null
      }
    }


    localValues.value = values
  },
  { immediate: true }
)

// Validaciones
const errors = ref({})

// Valida todos los campos mínimos y máximos
watch(localValues, (newValues) => {
  errors.value = {}

  const keys = Object.keys(newValues)
  const pares = keys
    .filter(k => k.startsWith('valor_minimo'))
    .map(minKey => {
      const suffix = minKey.replace('valor_minimo', '') // '' o '2'
      const maxKey = `valor_maximo${suffix}`
      return [minKey, maxKey]
    })

  for (const [minKey, maxKey] of pares) {
    const min = parseFloat(newValues[minKey])
    const max = parseFloat(newValues[maxKey])
    if (!isNaN(min) && !isNaN(max) && min > max) {
      errors.value[minKey] = 'El mínimo no puede ser mayor que el máximo.'
    }
  }
}, { deep: true })

function guardarCambios() {
  console.log(props.selectedDevice.id_dispositivo )
  if (Object.keys(errors.value).length > 0) return

  if (props.selectedDevice.id_dispositivo == 3) {

    const deviceHU = {
      id_dispositivo: 6,
      valor_minimo: localValues.value['humedadDHT11'][0],
      valor_maximo: localValues.value['humedadDHT11'][1],
    }

    const deviceTemp = {
      id_dispositivo: 3,
      valor_minimo: localValues.value['temperaturaDHT11'][0],
      valor_maximo: localValues.value['temperaturaDHT11'][1],
    }

    updateDevice(deviceHU)
    updateDevice(deviceTemp)

  } else {
    const deviceForm = {
      id_dispositivo: props.selectedDevice.id_dispositivo
    }
    for (const campo of props.selectedDevice.campos) {
      if (campo.slider === 'range') {
        deviceForm.valor_minimo = localValues.value[campo.name][0]
        deviceForm.valor_maximo = localValues.value[campo.name][1]
      } else {
        deviceForm[campo.name] = localValues.value[campo.name]
      }
    }
    updateDevice(deviceForm)
  }
}
</script>

<template>
  <div
    :class="[ 
      'col-span-12 md:col-span-6 xl:col-span-7 2xl:col-span-8 md:h-[calc(100vh-400px)] bg-white dark:bg-[var(--dark-dashboard)] text-gray-900 dark:text-white rounded-lg shadow-lg p-6 overflow-y-auto',
      selectedDevice ? 'block' : 'hidden',
      'md:block'
    ]"
  >
    <template v-if="selectedDevice">
      <!-- Encabezado -->
      <div class="flex gap-4 items-center p-4 mb-6 bg-[#97DFDB]/30 dark:bg-[var(--dark-dashboard)]/50 rounded-lg shadow-inner">
        <img
          :src="sensorForImages[selectedDevice.id_dispositivo]"
          alt="Sensor"
          class="object-contain w-16 h-16 rounded-md"
        />
        <div>
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ selectedDevice.nombre }}</h2>
          <p class="text-sm text-gray-500 dark:text-gray-300">{{ selectedDevice.descripcion }}</p>
        </div>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="guardarCambios" class="space-y-6">
        <div v-for="campo in selectedDevice.campos" :key="campo.name">
          <label :for="campo.name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
            {{ campo.label }}
          </label>

          <div class="flex items-center space-x-4">
            <!-- Slider normal -->
            <VSlider
              v-if="campo.slider === 'normal'"
              :id="campo.name"
              :step="campo.type === 'decimal' ? 0.1 : 1"
              :min="0"
              :max="60"
              v-model="localValues[campo.name]"
              :color="campo.type === 'decimal' ? '#6dbab9' : '#6dbab9'"
              :required="campo.required"
            />

            <!-- Slider de rango -->
            <VRangeSlider
              v-else
              :id="campo.name"
              :step="campo.type === 'decimal' ? 0.1 : 1"
              :min="selectedDevice.min"
              :max="selectedDevice.max"
              v-model="localValues[campo.name]"
              :color="campo.type === 'decimal' ? '#6dbab9' : '#6dbab9'"
              :required="campo.required"
            />

            <span class="flex flex-col items-end text-sm text-right text-gray-900 w-18 max-w-18 dark:text-white" v-if="campo.slider === 'range'">
              <span>min: {{ localValues[campo.name] ? localValues[campo.name][0] : 0 }}</span>
              <span>max: {{ localValues[campo.name] ? localValues[campo.name][1] : 0 }}</span>
            </span>

            <span class="flex flex-col items-end text-sm text-right text-gray-900 w-18 max-w-18 dark:text-white" v-else>
              {{ localValues[campo.name] ?? 0 }}
            </span>
          </div>

          <p v-if="errors[campo.name]" class="mt-1 text-sm text-red-400">
            {{ errors[campo.name] }}
          </p>
        </div>


        <VBtn
          type="submit"
          variant="elevated"
          color="primary"
          :loading="loading"
          :disabled="loading"
        >
          Guardar cambios
        </VBtn>
      </form>

      <!-- Botón volver en móviles -->
      <VBtn
        variant="outlined"
        color="primary"
        class="py-2 mt-6 md:hidden"
        @click="$emit('goBack')"
      >
        ← Volver
      </VBtn>
    </template>

    <template v-else>
      <p class="text-sm text-gray-300">
        Selecciona un dispositivo para ver y editar sus detalles.
      </p>
    </template>
  </div>
</template>

