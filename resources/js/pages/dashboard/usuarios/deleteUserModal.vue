<script setup>
import { useDeleteUser } from '@/hooks/users/useDeleteUser'
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  user: Object,
})


const emit = defineEmits(['update:modelValue', 'delete'])

const { loading, deleteUser } = useDeleteUser()

const isOpen = ref(props.modelValue)

watch(() => props.modelValue, val => {
  isOpen.value = val
})

watch(isOpen, val => emit('update:modelValue', val))

const confirmDelete = async () => {

  if (await deleteUser(props.user)) {
    emit('delete', true)
    isOpen.value = false
  }
}
</script>

<template>
  <VDialog
    v-model="isOpen"
    max-width="500px"
    persistent
  >
    <VCard>
      <VCardTitle class="text-xl font-semibold">
        ⚠️ Confirmar Eliminación
      </VCardTitle>

      <VCardText>
        ¿Estás seguro de que deseas eliminar el usuario
        <strong>{{ user.username }}</strong>? Esta acción no se puede deshacer.
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
          color="red darken-2"
          variant="flat"
          :loading="loading"
          :disabled="loading"
          @click="confirmDelete"
        >
          Eliminar
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
