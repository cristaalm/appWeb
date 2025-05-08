<script setup>
import { ref, reactive, watch } from 'vue'
import { useFormValidation } from './hooks/useFormValidation'
import { useImageValidation } from './hooks/useImageValidation'
import useCreateSystem from '@/hooks/Sistemas/useCreateSystem'

const props = defineProps({
  modelValue: Boolean,
})
const emit = defineEmits(['update:modelValue', 'create'])

const isOpen = ref(props.modelValue)
const loading = ref(false)
const fileInputRef = ref(null)

const form = reactive({
  razon_social: '',
  nombre_comercial: '',
  rfc: '',
  telefono: '',
  logotipo: null,
  estado: true,
})

const {
  razon_social_error,
  nombre_comercial_error,
  rfc_error,
  telefono_error,
  validateForm
} = useFormValidation(form)

const { createSystem, loading: loadingCreateSystem } = useCreateSystem()

const { imageError, validateImage } = useImageValidation(form)

const triggerFileInput = () => {
  fileInputRef.value?.click()
}

const getLogoPreview = () => {
  if (!form.logotipo) return null
  if (typeof form.logotipo === 'string') return form.logotipo
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
      razon_social: '',
      nombre_comercial: '',
      rfc: '',
      telefono: '',
      logotipo: null,
      estado: true,
    })
  }
})

watch(isOpen, val => emit('update:modelValue', val))

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
  const isImageValid = validateImage(form.logotipo)

  if (!isValid || !isImageValid) return

  loading.value = true
  try {
    const response = await createSystem(form)
    if (response.success) {
      loading.value = false
      isOpen.value = false
      emit('create', response.data)
    }
  } catch (e) {
    loading.value = false
    // error handling
  }
}
</script>

<template>
  <VDialog v-model="isOpen" max-width="700px" persistent>
    <VCard>
      <VCardTitle class="text-xl font-semibold">
        🏢 Nuevo Sistema
      </VCardTitle>

      <VCardText>
        <div class="flex flex-col items-center mb-8">
          <div class="relative mb-4">
            <div class="flex flex-col justify-center items-center cursor-pointer select-none group" @click="triggerFileInput">
              <div v-if="form.logotipo" class="flex justify-center">
                <img :src="getLogoPreview()" alt="Logotipo"
                     class="object-cover w-28 h-28 rounded-full border-4 shadow-lg transition-all duration-200 border-primary-500 group-hover:scale-105 group-hover:shadow-2xl" />
                <div class="absolute right-2 bottom-2 p-1 rounded-full border border-gray-200 shadow-md bg-slate-500">
                  <VIcon icon="bx-camera" size="20" class="text-primary-500 dark:text-white" />
                </div>
              </div>
              <div v-else class="flex relative justify-center items-center w-28 h-28 rounded-full border-4 border-dashed shadow-md transition-all duration-200 bg-theme-1/50 border-primary-300 group-hover:scale-105 group-hover:shadow-2xl">
                <VIcon size="40" icon="bx-image" class="text-primary-500" />
                <div class="absolute right-2 bottom-2 p-1 bg-[#284b53] rounded-full border border-white shadow-md">
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
          :disabled="loadingCreateSystem"
          :loading="loadingCreateSystem"
          @click="saveNewSystem"
        >
          Guardar
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
