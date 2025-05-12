<script setup>
import { useCreateUser } from '@/hooks/users/useCreateUser'
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
})

const emit = defineEmits(['update:modelValue', 'create'])

const { 
  catalog: empresas,
} = props.catalogSystem

const { loading, createUser } = useCreateUser()

const isOpen = ref(props.modelValue)

const form = reactive({
  "id_empresa": '',
  "username": '',
  "name": '',
  "email": '',
  "password": '',
  "confirmPassword": '',
  "nivel": 2,
  "estado": true,
})

watch(() => props.modelValue, val => {
  isOpen.value = val
  if (val) {
    Object.assign(form, {
      "id_empresa": '',
      "username": '',
      "name": '',
      "email": '',
      "password": '',
      "nivel": 2,
      "estado": true,
    })
  }
})

watch(isOpen, val => emit('update:modelValue', val))

const empresaError = ref(false)
const usernameError = ref(false)
const nameError = ref(false)
const emailError = ref(false)
const passwordError = ref(false)
const confirmPasswordError = ref(false)
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

function validatePasswordMatch() {
  if (form.confirmPassword !== form.password) {
    confirmPasswordError.value = "Las contraseñas no coinciden"
  } else {
    confirmPasswordError.value = false
  }
}

watch(() => form.password, val => {
  if (val.length < 8) {
    passwordError.value = "La contraseña debe tener al menos 8 caracteres"
  } else {
    passwordError.value = false
  }
  validatePasswordMatch();
})

watch(() => form.confirmPassword, val => {
  validatePasswordMatch();
})


const validateForm = () => {
  empresaError.value = !form.id_empresa
  usernameError.value = !form.username.trim()
  nameError.value = !form.name.trim()
  emailError.value = !form.email.trim() || emailError.value
  passwordError.value = !form.password.trim() || passwordError.value
  confirmPasswordError.value = form.confirmPassword !== form.password || !form.confirmPassword.trim()
  nivelError.value = !form.nivel
  
  return !empresaError.value && !usernameError.value && !nameError.value && !emailError.value && !passwordError.value && !confirmPasswordError.value && !nivelError.value
}

const saveNewUser = async () => {
  if (loading.value) return
  if (!validateForm()) return
  // Prepara el payload para el backend
  const user = {
    ...form,
    password_confirmation: form.confirmPassword
  }
  delete user.confirmPassword
  if (await createUser(user)) {
    isOpen.value = false
    emit('create', true)
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
        📝 Nuevo Usuario
      </VCardTitle>
      <VCardText class="space-y-4">
        <VTextField
          v-model="form.name"
          label="Nombre del usuario"
          outlined
          dense
          :error="!!nameError"
          :error-messages="nameError ? nameError : ''"
          @keydown.enter.prevent="saveNewUser"
        />

        <!-- agregamos un select que tenga integrado un buscador para querys -->
        <VTextField
          v-model="form.username"
          label="Usuario"
          outlined
          dense
          :error="!!usernameError"
          :error-messages="usernameError ? usernameError : ''"
          @keydown.enter.prevent="saveNewUser"
        />

        <VTextField
          v-model="form.email"
          label="Correo"
          outlined
          dense
          :error="!!emailError"
          :error-messages="emailError ? emailError : ''"
          @keydown.enter.prevent="saveNewUser"
        />

        <VTextField
          v-model="form.password"
          label="Contraseña"
          type="password"
          outlined
          dense
          :error="!!passwordError"
          :error-messages="passwordError ? passwordError : ''"
          @keydown.enter.prevent="saveNewUser"
        />
        <VTextField
          v-model="form.confirmPassword"
          label="Confirmar contraseña"
          type="password"
          outlined
          dense
          :error="!!confirmPasswordError"
          :error-messages="confirmPasswordError ? confirmPasswordError : ''"
          @keydown.enter.prevent="saveNewUser"
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
          @keydown.enter.prevent="saveNewUser"
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
          :disabled="loading || !form.id_empresa || !form.username.trim() || !form.name.trim() || !form.email.trim() || !form.password.trim()"
          :loading="loading"
          @click="saveNewUser"
        >
          Guardar
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
