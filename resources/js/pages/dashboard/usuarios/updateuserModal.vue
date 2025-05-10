<script setup>
import { useUpdateUser } from '@/hooks/users/useUpdateUser'
import { reactive, ref, watch } from 'vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
  catalogSystem: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: false,
    default: null,
  },
})

const emit = defineEmits(['update:modelValue', 'update'])

const { updateUser, loading: loadingUpdateUser } = useUpdateUser()

const { 
  catalog: empresas,
} = props.catalogSystem

const isOpen = ref(props.modelValue)

// Guardamos el usuario original para comparar
let originalUser = {}

const form = reactive({
  id_empresa: '',
  username: '',
  name: '',
  email: '',
  nivel: 1,
  estado: true,
})

// Al abrir el modal, copiamos los datos del usuario
watch(() => props.modelValue, val => {
  isOpen.value = val
  if (val && props.user) {
    Object.assign(form, {
      id_empresa: props.user.id_empresa || '',
      username: props.user.username || '',
      name: props.user.name || '',
      email: props.user.email || '',
      nivel: props.user.nivel || 1,
      estado: props.user.estado !== undefined ? props.user.estado : true,
    })
    originalUser = {
      id_empresa: props.user.id_empresa || '',
      username: props.user.username || '',
      name: props.user.name || '',
      email: props.user.email || '',
      nivel: props.user.nivel || 1,
      estado: props.user.estado !== undefined ? props.user.estado : true,
    }
  }
})

watch(isOpen, val => emit('update:modelValue', val))

const empresaError = ref(false)
const usernameError = ref(false)
const nameError = ref(false)
const emailError = ref(false)
const nivelError = ref(false)

watch(() => form.id_empresa, val => {
  if (val) empresaError.value = false
})

watch(() => form.username, val => {
  if (val.trim()) usernameError.value = false
})

watch(() => form.name, val => {
  if (val.trim()) nameError.value = false
})

watch(() => form.email, val => {
  if (!/^\S+@\S+\.\S+$/.test(val)){
    emailError.value = "El correo debe ser valido"
  } else {
    emailError.value = false
  }
})

const validateForm = () => {
  empresaError.value = !form.id_empresa
  usernameError.value = !form.username.trim()
  nameError.value = !form.name.trim()
  emailError.value = !form.email.trim() || emailError.value
  nivelError.value = !form.nivel
  
  return !empresaError.value && !usernameError.value && !nameError.value && !emailError.value && !nivelError.value
}

function isFormChanged() {
  // Solo comparamos los campos editables, no password
  return (
    form.id_empresa !== originalUser.id_empresa ||
    form.username !== originalUser.username ||
    form.name !== originalUser.name ||
    form.email !== originalUser.email ||
    form.nivel !== originalUser.nivel ||
    form.estado !== originalUser.estado
  )
}

const saveUpdateUser = async () => {
  if (loadingUpdateUser.value) return
  if (!validateForm() || !isFormChanged()) return
  // Prepara el payload para el backend
  const user = {
    ...originalUser,
    id: props.user.id,
    id_empresa: form.id_empresa,
    username: form.username,
    name: form.name,
    email: form.email,
    nivel: form.nivel,
    estado: form.estado,
  }
  if (await updateUser(user)) {
    isOpen.value = false
    emit('update', true)
  }
}
</script>

<template>
  <VDialog
    v-model="isOpen"
    max-width="700px"
    persistent
  >
    <VCard>
      <VCardTitle class="text-xl font-semibold">
        ✏️ Editar Usuario
      </VCardTitle>
      <VCardText class="space-y-4">
        <VTextField
          v-model="form.name"
          label="Nombre del usuario"
          outlined
          dense
          :error="!!nameError"
          :error-messages="nameError ? nameError : ''"
          @keydown.enter.prevent="saveUpdateUser"
        />

        <!-- agregamos un select que tenga integrado un buscador para querys -->
        <VTextField
          v-model="form.username"
          label="Usuario"
          outlined
          dense
          :error="!!usernameError"
          :error-messages="usernameError ? usernameError : ''"
          @keydown.enter.prevent="saveUpdateUser"
        />

        <VTextField
          v-model="form.email"
          label="Correo"
          outlined
          dense
          :error="!!emailError"
          :error-messages="emailError ? emailError : ''"
          @keydown.enter.prevent="saveUpdateUser"
        />
        
        <VSelect
          v-model="form.id_empresa"
          :items="empresas"
          item-title="nombre_comercial"
          item-value="id_empresa"
          label="Empresa"
          outlined
          dense
          :error="!!empresaError"
          :error-messages="empresaError ? empresaError : ''"
          maxlength="2"
          @keydown.enter.prevent="saveUpdateUser"
        />

        <VTable class="mt-4 text-no-wrap">
          <thead>
            <tr>
              <th>Configuración</th>
              <th>Valor</th>
              <th>Descripción</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Estado</td>
              <td>
                <VCheckbox v-model="form.estado" />
              </td>
              <td class="text-sm text-gray-500 dark:text-slate-300">
                El usuario podra iniciar sesion
              </td>
            </tr>
          </tbody>
        </VTable>
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
          color="#3a9291"
          variant="flat"
          :disabled="loadingUpdateUser || !form.id_empresa || !form.username.trim() || !form.name.trim() || !form.email.trim() || !isFormChanged()"
          :loading="loadingUpdateUser"
          @click="saveUpdateUser"
        >
          Guardar
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
