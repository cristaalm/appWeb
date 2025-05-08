<script setup>
import useResetPassword from '@/hooks/Auth/useResetPassword'
import LoadingIcon from '@/components/Base/LoadingIcon/'
import authV1BottomShape from '@images/icons/login/8.png?url'
import authV1TopShape from '@images/icons/login/1.png?url'
import { useRouter } from 'vue-router'
import { defineProps, onMounted } from 'vue'

const props = defineProps({
  token: {
    type: String,
    required: true,
  },
  email: {
    type: String,
    required: true,
  },
})

onMounted(() => {
  console.log('Token:', props.token)
  console.log('Email:', props.email)

  if (!props.token || !props.email) {
    router.push('/')
  }
})

const router = useRouter()

const form = ref({
  newPassword: '',
  confirmPassword: '',
  token: props.token,
  email: props.email,
})

const {
  success,
  loading,
  resetPassword,
} = useResetPassword()

const isPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)
</script>

<template>
  <div class="justify-center auth-wrapper d-flex align-center pa-4 bg-[#e0fffd] ">
    <div class="position-relative my-sm-16">
      <!-- 👉 Top shape -->
      <VImg :src="authV1TopShape" :class="success ? '!hidden' : ''"
        class="text-primary auth-v1-top-shape !absolute d-none d-sm-block transform rotate-90 opacity-70" />

      <!-- 👉 Bottom shape -->
      <VImg :src="authV1BottomShape" :class="success ? '!hidden' : ''"
        class="text-primary auth-v1-bottom-shape !absolute d-none d-sm-block transform -rotate-90 opacity-70" />

      <!-- 👉 Auth Card -->
      <VCard class="auth-card"
        :class="[success ? 'animate-scaleDown mt-[120px]' : 'animate-scaleUp', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']"
        max-width="460">
        <VCardItem class="justify-center">
          <RouterLink to="/" class="app-logo">
            <div class="d-flex">
              <img src="/logo.png" alt="UNIAMA" class="w-[200px] mr-2">
            </div>
          </RouterLink>
        </VCardItem>

        <VCardText>
          <h4 class="relative mb-1 text-h4">
            Restablecer Contraseña <span
              class="absolute -top-2 ml-2 text-4xl transition-all duration-200 transform animate-wave">🔐</span>
          </h4>
          <p class="mb-0">
            Ingresa tu nueva contraseña para restablecer el acceso a tu cuenta.
          </p>
        </VCardText>

        <VCardText>
          <VForm @submit.prevent="">
            <VRow>
              <!-- new password -->
              <VCol cols="12">
                <VTextField v-model="form.newPassword" label="Nueva Contraseña" placeholder="**********"
                  :type="isPasswordVisible ? 'text' : 'password'" autocomplete="password"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible" />
              </VCol>

              <!-- confirm password -->
              <VCol cols="12">
                <VTextField v-model="form.confirmPassword" label="Confirmar Contraseña" placeholder="**********"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'" autocomplete="password"
                  :append-inner-icon="isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible" />
              </VCol>

              <!-- submit button -->
              <VCol cols="12">
                <VBtn block type="submit" :disabled="loading || !form.newPassword || !form.confirmPassword || success"
                  @click="resetPassword(form)">
                  <span v-if="loading">
                    <LoadingIcon icon="three-dots" />
                  </span>
                  <span v-else>
                    Restablecer Contraseña
                  </span>
                </VBtn>
                <VBtn block type="button" variant="text" :disabled="loading" class="mt-4"
                  @click="router.push('/login')">
                  Regresar
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
      <VCard class="auth-card"
        :class="[success ? 'animate-scaleUp' : '!hidden', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']" max-width="460">
        <div class="text-center pa-6">
          <VAvatar size="80" color="primary" class="p-3 mb-4">
            <Lucide icon="CircleCheckBig" class="w-full h-full" />
          </VAvatar>

          <h2 class="mb-2 !text-3xl !font-bold text-h5">
            ¡Contraseña Restablecida!
          </h2>

          <p class="mb-6 text-body-1 !text-xl">
            Tu contraseña ha sido restablecida con éxito.
            <br>
            Ahora puedes iniciar sesión con tu nueva contraseña.
          </p>

          <VBtn block color="primary" @click="router.push('/login')">
            Ir al inicio de sesión
          </VBtn>
        </div>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth";
</style>
