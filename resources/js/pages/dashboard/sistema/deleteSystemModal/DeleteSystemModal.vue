<script setup>
import { ref, watch } from 'vue'
import useDeleteSystem from '@/hooks/Sistemas/useDeleteSystem'

const props = defineProps({
  modelValue: Boolean,
  sistema: Object
})
const emit = defineEmits(['update:modelValue', 'deleted'])

const isOpen = ref(props.modelValue)
watch(() => props.modelValue, val => (isOpen.value = val))
watch(isOpen, val => emit('update:modelValue', val))

const loading = ref(false)
const errorMessage = ref(null)

const { deleteSystem } = useDeleteSystem()

const confirmDelete = async () => {
  loading.value = true
  errorMessage.value = null
  try {
    const response = await deleteSystem(props.sistema.id_empresa)
    if (response.success) {
      emit('deleted', props.sistema.id_empresa)
      isOpen.value = false
    } else {
      errorMessage.value = response.message
    }
  } catch (error) {
    errorMessage.value = 'No se pudo eliminar el sistema. Verifica si está relacionado con otros datos.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <VDialog v-model="isOpen" max-width="500px" persistent>
    <VCard>
      <VCardTitle class="text-xl font-semibold">Eliminar sistema</VCardTitle>
      <VCardText>
        <p>¿Estás seguro que deseas eliminar el sistema <strong>{{ sistema.nombre_comercial }}</strong>? Esta acción no se puede deshacer.</p>
        <p v-if="errorMessage" class="mt-4 text-sm text-red-500">{{ errorMessage }}</p>
      </VCardText>
      <VCardActions class="justify-end mt-4 space-x-2">
        <VBtn variant="text" @click="isOpen = false">Cancelar</VBtn>
        <VBtn color="red" variant="flat" :loading="loading" @click="confirmDelete">Eliminar</VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
