<script setup>
import { ref, watch } from 'vue'
import useChangeStatus from '@/hooks/Sistemas/useChangeStatus'

const props = defineProps({
  sistema: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['changeStatus', 'handleUpdate', 'handleDelete'])

const switchValue = ref(false)
const { changeStatusSistema, loading } = useChangeStatus()

watch(
  () => props.sistema.estado,
  (val) => {
    switchValue.value = val
  },
  { immediate: true } // Esto asegura que switchValue se inicializa bien al cargar
)

async function toggleEstado() {
  const newStatus = await changeStatusSistema(props.sistema.id_empresa, !props.sistema.estado)
  if (newStatus) {
    emit('changeStatus', newStatus.data)
  }
}
function handleDelete() {
  emit('handleDelete', props.sistema)
}

function handleUpdate() {
  emit('handleUpdate', props.sistema)
}

</script>
<template>
  <VCard
    class="rounded-2xl border border-gray-200 shadow-md transition-all hover:shadow-lg"
    :class="!sistema.estado ? 'opacity-60 grayscale' : ''"
  >
    <VCardText class="flex gap-4 items-center p-6 pb-4">
      <VAvatar size="64" class="border border-gray-300">
        <VImg :src="sistema.logotipo || '/images/placeholderImage.jpg'" alt="Logo" cover />
      </VAvatar>

      <div class="flex-1 min-w-0">
        <h3 class="text-lg font-semibold truncate">{{ sistema.nombre_comercial }}</h3>
        <p class="text-sm text-gray-500 truncate dark:text-slate-300">{{ sistema.razon_social }}</p>
        <div class="flex gap-2 items-center mt-1 text-sm text-gray-500 dark:text-slate-300">
          <VChip small class="px-2 text-xs !bg-[#e8f4f4] dark:!bg-[#115557]">RFC</VChip>
          <span>{{ sistema.rfc }}</span>
        </div>
        <div class="flex gap-2 items-center mt-1 text-sm text-gray-500 dark:text-slate-300">
          <VIcon size="16" class="text-gray-400">bx-phone</VIcon>
          <span>{{ sistema.telefono }}</span>
        </div>
      </div>

      <div class="flex flex-col gap-2 items-end">
        <IconBtn :disabled="!switchValue">
          <VIcon icon="bx-dots-vertical-rounded" />
          <VMenu activator="parent" width="200" location="bottom end" offset="14px">
            <VList>
              <VListItem @click="handleUpdate">
                <template #prepend>
                  <VIcon class="me-2" icon="bx-pencil" size="22" />
                </template>
                <VListItemTitle>Editar</VListItemTitle>
              </VListItem>

              <VListItem @click="handleDelete">
                <template #prepend>
                  <VIcon class="me-2 text-error" icon="bx-trash" size="22" />
                </template>
                <VListItemTitle>Eliminar</VListItemTitle>
              </VListItem>
            </VList>
          </VMenu>
        </IconBtn>
      </div>
    </VCardText>

    <VDivider />

    <VCardActions class="flex justify-between px-6 py-3 bg-[#e8f4f4] dark:bg-theme-1/50 dark:text-white">
      <span class="text-sm font-medium text-gray-700 dark:text-white">Estado</span>
      <VSwitch
        v-if="!loading"
        v-model="switchValue"
        @change="toggleEstado"
        hide-details
        inset
      />
      <LoadingIcon v-else icon="tail-spin" class="w-9 h-9" />
    </VCardActions>
  </VCard>
</template>
