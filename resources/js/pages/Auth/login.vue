<script setup>
import LoadingIcon from '@/components/Base/LoadingIcon/'
import Lucide from '@/components/Base/Lucide/'
import useLogin from '@/hooks/Auth/useLogin'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import authV1BottomShape from '@images/icons/login/8.png?url'
import authV1TopShape from '@images/icons/login/1.png?url'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
  user: '',
  pass: '',
  remember: false,
})

const {
  user,
  success,
  loading,
  loginUser,
} = useLogin()

const isPasswordVisible = ref(false)
</script>

<template>
  <div class="justify-center auth-wrapper d-flex align-center pa-4 bg-[#e0fffd] ">
    <div class="position-relative my-sm-16">
      <!-- Top shape -->
      <VImg
        :src="authV1TopShape"
        :class="success ? '!hidden' : ''"
        class="text-primary auth-v1-top-shape !absolute d-none d-sm-block transform rotate-90 opacity-70"
      />

      <!-- Bottom shape -->
      <VImg
        :src="authV1BottomShape"
        :class="success ? '!hidden' : ''" 
        class="text-[#7bbbc2] auth-v1-bottom-shape !absolute d-none d-sm-block transform -rotate-90 opacity-70"
      />

      <!-- Auth Card -->
      <VCard
        class="flex !flex-row auth-card md:w-[800px]  bg-transparent py-16"
        :class="[success ? 'animate-scaleDown mt-[120px]' : 'animate-scaleUp', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']"
      >
      <div class="flex !flex-row">
        <div class="hidden flex-col justify-center items-center bg-no-repeat bg-cover md:w-1/2 sm:flex">
          <img src="/logo.png" alt="AQUANOVA" class="w-[200px] mr-2">
        </div>
        <div class="w-full md:w-1/2">
          <VCardText>
            <h4 class="relative mb-1 text-h4 text-[#20797a] font-bold">
              ¡Bienvenido a AQUANOVA! <span class="hidden absolute -top-2 ml-2 text-4xl transition-all duration-200 transform md:inline-block animate-wave">👋🏻</span>
            </h4>
            <p class="mb-0">
              Inicie sesión en su cuenta para continuar.
            </p>
          </VCardText>

          <VCardText>
            <VForm @submit.prevent="">
              <VRow>
                <!-- email -->
                <VCol cols="12">
                  <VTextField
                    v-model="form.user"
                    autofocus
                    label="Usuario"
                    type="text"
                    placeholder="Usuario"
                    color="#20797a"
                    :loading="loading"
                    :disabled="loading"
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
                    color="#20797a"
                    :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                    @click:append-inner="isPasswordVisible = !isPasswordVisible"
                    :loading="loading"
                    :disabled="loading"
                  />

                  <!-- remember me checkbox -->
                  <div class="flex-wrap my-6 d-flex align-center justify-space-between">
                    <VCheckbox
                      v-model="form.remember"
                      color="#20797a"
                      label="Mantener sesión"
                    />

                    <a
                      class="text-[#20797a]"
                      href="./forgot-password"
                      @click.prevent="router.push('/forgot-password')"
                    >
                      Olvidé mi contraseña
                    </a>
                  </div>

                  <!-- login button -->
                  <VBtn
                    block
                    type="submit"
                    color="#20797a"
                    :disabled="loading || !form.user || !form.pass || success"
                    @click="loginUser(form)"
                  >
                    <span v-if="loading">
                      <LoadingIcon icon="three-dots" />
                    </span>
                    <span v-else>
                      Iniciar sesión
                    </span>
                  </VBtn>

                  <!-- regresar -->
                  <VBtn
                    block
                    type="button"
                    color="#20797a"
                    variant="text"
                    :disabled="loading"
                    class="mt-4"
                    @click="router.push('/')"
                  >
                    Regresar
                  </VBtn>
                </VCol>

                <VCol
                  cols="12"
                  class="d-flex align-center !hidden"
                >
                  <VDivider />
                  <span class="mx-4 text-high-emphasis !pb-0">contactanos</span>
                  <VDivider />
                </VCol>

                <!-- auth providers -->
                <VCol
                  cols="12"
                  class="text-center !pt-0 !hidden"
                >
                  <AuthProvider />
                </VCol>
              </VRow>
            </VForm>
          </VCardText>
        </div>
      </div>
      </VCard>
      <VCard
        class="auth-card"
        :class="[success ? 'animate-scaleUp' : '!hidden', $vuetify.display.smAndUp ? 'pa-6' : 'pa-0']"
        max-width="700"
      >
        <div class="text-center pa-6">
          <VAvatar
            size="80"
            color="#20797a"
            class="p-3 mb-4"
          >
            <Lucide
              icon="CircleCheckBig"
              class="w-full h-full"
            />
          </VAvatar>
    
          <h2 class="mb-2 !text-3xl !font-bold text-h5">
            ¡Bienvenido, {{ user?.name || "" }}!
          </h2>
    
          <p class="mb-6 text-body-1 !text-xl">
            Has iniciado sesión con éxito.
            <br>
            ¡Disfruta de tu día!
          </p>
        </div>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth";
</style>
