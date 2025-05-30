<script setup>
import { ref, reactive, watch, computed } from 'vue'
import { useFormValidation } from './hooks/useFormValidation'
import { useImageValidation } from './hooks/useImageValidation'
import useUpdateSystem from '@/hooks/Sistemas/useUpdateSystem'

const props = defineProps({
  modelValue: Boolean,
  sistema: Object,
})
const emit = defineEmits(['update:modelValue', 'create', 'update'])

const isOpen = ref(props.modelValue)
const loading = ref(false)
const fileInputRef = ref(null)

const form = reactive({
  id_empresa: '',
  razon_social: '',
  nombre_comercial: '',
  rfc: '',
  telefono: '',
  logotipo: null,
  estado: true,
})

const originalData = reactive({})

const {
  razon_social_error,
  nombre_comercial_error,
  rfc_error,
  telefono_error,
  validateForm
} = useFormValidation(form)

const { updateSystem, loading: loadingUpdateSystem } = useUpdateSystem()

const { imageError, validateImage } = useImageValidation(form)

const triggerFileInput = () => {
  fileInputRef.value?.click()
}

const getLogoPreview = () => {
  if (!form.logotipo) return null
  if (typeof form.logotipo === 'string') {
    // Ruta absoluta desde el backend
    return `${window.location.origin}${form.logotipo}`
  }
  try {
    return URL.createObjectURL(form.logotipo)
  } catch {
    return null
  }
}

watch(() => props.modelValue, val => {
  isOpen.value = val
  if (val) {
    Object.assign(form, {
      id_empresa: props.sistema.id_empresa,
      razon_social: props.sistema.razon_social,
      nombre_comercial: props.sistema.nombre_comercial,
      rfc: props.sistema.rfc,
      telefono: props.sistema.telefono,
      logotipo: props.sistema.logotipo,
      estado: props.sistema.estado,
    })

    // Guardar copia original para comparar luego
    Object.assign(originalData, JSON.parse(JSON.stringify(form)))
  }
})

watch(isOpen, val => emit('update:modelValue', val))

const removeImage = () => {
  form.logotipo = null
}

const hasChanges = computed(() => {
  const originalLogo = originalData.logotipo ?? null
  const currentLogo = form.logotipo

  const logoChanged =
    (typeof currentLogo === 'object') ||
    (currentLogo === null && originalLogo !== null)

  return (
    form.razon_social !== originalData.razon_social ||
    form.nombre_comercial !== originalData.nombre_comercial ||
    form.rfc !== originalData.rfc ||
    form.telefono !== originalData.telefono ||
    form.estado !== originalData.estado ||
    logoChanged
  )
})


const handleImageChange = (e) => {
  const file = e.target.files[0]
  if (validateImage(file)) {
    form.logotipo = file
  } else {
    form.logotipo = null
  }
}

const saveNewSystem = async () => {
  const isValid = validateForm()
  
  const originalLogo = originalData.logotipo ?? null
  const currentLogo = form.logotipo

  const logoChanged =
    (typeof currentLogo === 'object') ||
    (currentLogo === null && originalLogo !== null)

  let isImageValid = true
  if (logoChanged) {
    isImageValid = validateImage(form.logotipo)
    if (!isImageValid) return
  }

  if (!isValid || !isImageValid) return

  loading.value = true
  try {
    const response = await updateSystem(form)
    if (response.success) {
      loading.value = false
      isOpen.value = false
      emit('update', response.data)
    }
  } catch (e) {
    loading.value = false
    // manejar error
  }
}
</script>

<template>
  <VDialog v-model="isOpen" max-width="700px" persistent>
    <VCard>
      <VCardTitle class="text-xl font-semibold">
        🏢 Actualizar Sistema
      </VCardTitle>

      <VCardText>
        <div class="flex flex-col items-center mb-8">
          <div class="relative mb-4">
            <div
              class="flex flex-col justify-center items-center cursor-pointer select-none group"
              @click="triggerFileInput"
            >
              <div v-if="getLogoPreview()" class="flex relative justify-center">
                <img
                  :src="getLogoPreview()"
                  alt="Logotipo"
                  class="object-cover w-28 h-28 rounded-full border-4 shadow-lg transition-all duration-200 border-primary-500 group-hover:scale-105 group-hover:shadow-2xl"
                />
                <div class="absolute right-0 bottom-0 p-1 rounded-full border border-gray-200 shadow-md bg-slate-500">
                  <VIcon icon="bx-camera" size="20" class="text-white dark:text-white" />
                </div>
                <!-- Botón de eliminar imagen -->
                <button
                  type="button"
                  class="flex absolute bottom-0 left-0 z-10 justify-center items-center w-8 h-8 text-white bg-red-600 rounded-full shadow-md hover:bg-red-700"
                  @click.stop.prevent="removeImage"
                >
                  <VIcon icon="bx-x" size="20" />
                </button>
              </div>
              <div
                v-else
                class="flex relative justify-center items-center w-28 h-28 rounded-full border-4 border-dashed shadow-md transition-all duration-200 bg-theme-1/50 border-primary-300 group-hover:scale-105 group-hover:shadow-2xl"
              >
                <VIcon size="40" icon="bx-image" class="text-primary-500" />
                <div
                  class="absolute right-0 bottom-0 p-1 bg-[#284b53] rounded-full border border-white shadow-md"
                >
                  <VIcon icon="bx-camera" size="20" class="text-black dark:text-white" />
                </div>
              </div>
            </div>

            <input
              ref="fileInputRef"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleImageChange"
            />
            <p v-if="imageError" class="mt-2 text-sm text-red-500">{{ imageError }}</p>
          </div>
        </div>

        <VTextField
          v-model="form.razon_social"
          label="Razón social"
          outlined
          dense
          :error="!!razon_social_error"
          :error-messages="razon_social_error"
          class="mb-4"
        />
        <VTextField
          v-model="form.nombre_comercial"
          label="Nombre comercial"
          outlined
          dense
          :error="!!nombre_comercial_error"
          :error-messages="nombre_comercial_error"
          class="mb-4"
        />
        <VTextField
          v-model="form.rfc"
          label="RFC"
          outlined
          dense
          :error="!!rfc_error"
          :error-messages="rfc_error"
          class="mb-4"
        />
        <VTextField
          v-model="form.telefono"
          label="Teléfono"
          outlined
          dense
          :error="!!telefono_error"
          :error-messages="telefono_error"
          class="mb-4"
        />

        <div class="mt-4">
          <VCheckbox v-model="form.estado" label="Activo" />
        </div>
      </VCardText>

      <VDivider />

      <VCardActions class="justify-end mt-2 space-x-2">
        <VBtn
          variant="elevated"
          color="grey darken-1"
          @click="isOpen = false"
        >
          Cancelar
        </VBtn>
        <VBtn
          color="#6dbab9"
          class="text-white"
          variant="flat"
          :disabled="loading || !hasChanges"
          :loading="loading"
          @click="saveNewSystem"
        >
          Guardar
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
