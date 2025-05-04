<script setup>
import LoadingIcon from '@/components/Base/LoadingIcon/'
import Lucide from '@/components/Base/Lucide/'
import useLogin from '@/hooks/Auth/useLogin'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?url'
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?url'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
  email: '',
  pass: '',
  remember: false,
})

const {
  user,
  success,
  error,
  loading,
  loginUser,
} = useLogin()

const isPasswordVisible = ref(false)
</script>

<template>
  <!-- <div class="justify-center auth-wrapper d-flex align-center pa-4 bg-gradient-to-b from-purple-500 to-blue-300"> -->
  <div class="justify-center auth-wrapper d-flex align-center pa-4 bg-[url('/images/background.jpg')] bg-cover ">
    <div class="position-relative my-sm-16">
      <!-- 👉 Top shape -->
      <VImg
        :src="authV1TopShape"
        :class="success ? '!hidden' : ''"
        class="text-primary auth-v1-top-shape !absolute d-none d-sm-block"
      />

      <!-- 👉 Bottom shape -->
      <VImg
        :src="authV1BottomShape"
        :class="success ? '!hidden' : ''"
        class="text-primary auth-v1-bottom-shape !absolute d-none d-sm-block"
      />

      <!-- 👉 Auth Card -->
      <!-- cuando success sea true, agregamos la clase animate-scaleUp -->
      <VCard
        class="auth-card"
        :class="[success ? 'animate-scaleDown mt-[120px]' : 'animate-scaleUp', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']"
        max-width="460"
      >
        <VCardItem class="justify-center">
          <RouterLink
            to="/"
            class="app-logo"
          >
            <!-- eslint-disable vue/no-v-html -->
            <div class="d-flex">
              <img
                src="/logo.png"
                alt="UNIAMA"
                class="w-[200px] mr-2"  
              >
            </div>
            <!--
              <h1 class="font-bold text-h4">
              UNIAMA
              </h1> 
            -->
          </RouterLink>
        </VCardItem>

        <VCardText>
          <h4 class="relative mb-1 text-h4">
            ¡Bienvenido a Uniama! <span class="absolute ml-2 text-4xl transition-all duration-200 transform animate-wave -top-2">👋🏻</span>
          </h4>
          <p class="mb-0">
            Inicie sesion en su cuenta y comience con su dia.
          </p>
        </VCardText>

        <VCardText>
          <VForm @submit.prevent="$router.push('/')">
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <VTextField
                  v-model="form.email"
                  autofocus
                  label="Correo Electronico"
                  type="email"
                  placeholder="johndoe@email.com"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  v-model="form.pass"
                  label="Contraseña"
                  placeholder="**********"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  autocomplete="password"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <!-- remember me checkbox -->
                <div class="flex-wrap my-6 d-flex align-center justify-space-between">
                  <VCheckbox
                    v-model="form.remember"
                    label="Mantener sesion"
                  />

                  <a
                    class="text-primary"
                    href="./forgot-password"
                    @click.prevent="router.push('/forgot-password')"
                  >
                    Olvide mi contraseña
                  </a>
                </div>

                <!-- login button -->
                <VBtn
                  block
                  type="submit"
                  :disabled="loading || !form.email || !form.pass || success"
                  @click="loginUser(form)"
                >
                  <span v-if="loading">
                    <LoadingIcon icon="three-dots" />
                  </span>
                  <span v-else>
                    Iniciar Sesion
                  </span>
                </VBtn>
              </VCol>

              <VCol
                cols="12"
                class="d-flex align-center"
              >
                <VDivider />
                <span class="mx-4 text-high-emphasis !pb-0">contactanos</span>
                <VDivider />
              </VCol>

              <!-- auth providers -->
              <VCol
                cols="12"
                class="text-center !pt-0"
              >
                <AuthProvider />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
      <VCard
        class="auth-card"
        :class="[success ? 'animate-scaleUp' : '!hidden', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']"
        max-width="460"
      >
        <div class="text-center pa-6">
          <VAvatar
            size="80"
            color="primary"
            class="p-3 mb-4"
          >
            <Lucide
              icon="CircleCheckBig"
              class="w-full h-full"
            />
          </VAvatar>
    
          <h2 class="mb-2 !text-3xl !font-bold text-h5">
            ¡Bienvenido, {{ user?.first_name || "" }}!
          </h2>
    
          <p class="mb-6 text-body-1 !text-xl">
            Has iniciado sesion con exito.
            <br>
            ¡Disfruta de tu dia!
          </p>
        </div>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth";
</style>
