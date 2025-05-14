<script setup>
import Footer from '@/layouts/components/Footer.vue'
import NavItems from '@/layouts/components/NavItems/NavItems.vue'
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue'
import LoadingIcon from '@/components/Base/LoadingIcon/LoadingIcon.vue'
import useLogout from '@/hooks/Auth/useLogout'
import { useThemeSwitcher } from '@/hooks/useThemeSwitcher'

const { themeName, changeTheme, globalTheme, logoutMode } = useThemeSwitcher()
const { loadingLogout, logoutUser } = useLogout()

const user = JSON.parse(localStorage.getItem('user')) || {}
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <!-- 👉 Vertical nav toggle in overlay mode -->
        <IconBtn
          class="ms-n3 d-lg-none"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="bx-menu" />
        </IconBtn>

        <!-- 👉 Search -->
        <div
          class="min-w-0 cursor-text d-flex align-center ms-lg-n3"
          style="user-select: none;"
        >
          <!-- mensaje de bienvenida -->
          <span class="text-[#20797a] dark:text-[#c5efec] mb-[2px] ml-2 text-xl md:text-3xl text-nowrap truncate font-bold">Bienvenido<span class="inline md:hidden">,</span> <span class="hidden md:inline">al panel de control</span> {{ user.name }}</span>
        </div>

        <VSpacer />

        <IconBtn :disabled="loadingLogout" :loading="loadingLogout">
          <VIcon icon="bx-dots-vertical-rounded" />
          <VMenu activator="parent" width="230" location="bottom end" offset="14px">
            <VList>
              <!-- 👉 Configuración -->
              <VListItem link>
                <template #prepend>
                  <VIcon
                    class="me-2"
                    icon="bx-cog"
                    size="22"
                  />
                </template>
                <VListItemTitle>Configuración</VListItemTitle>
              </VListItem>

              <!-- 👉 Modo oscuro / claro -->
              <VListItem link @click="changeTheme">
                <template #prepend>
                  <VIcon
                    class="me-2"
                    :icon="themeName === 'dark' ? 'bx-sun' : 'bx-moon'"
                    size="22"
                  />
                </template>
                <VListItemTitle>Modo {{ themeName === 'dark' ? 'claro' : 'oscuro' }}</VListItemTitle>
              </VListItem>

              <VDivider class="my-2" />

              <!-- 👉 Logout -->
              <VListItem @click.prevent="()=>{logoutUser(logoutMode)}">
                <template #prepend>
                  <VIcon
                    v-if="!loadingLogout"
                    class="me-2"
                    icon="bx-log-out"
                    size="22"
                  />
                  <LoadingIcon
                    v-else
                    icon="tail-spin"
                    class="mr-5"
                  />
                </template>
                <VListItemTitle>
                  Logout
                </VListItemTitle>
              </VListItem>
            </VList>
          </VMenu>
        </IconBtn>
      </div>
    </template>

    <template #vertical-nav-header="{ toggleIsOverlayNavActive }">
      <RouterLink
        to="/panel"
        class="flex justify-center items-center w-full app-logo app-title-wrapper"
      >
        <!-- eslint-disable vue/no-v-html -->
        <div class="d-flex">
          <img
            :src="globalTheme.name.value == 'dark' ? '/logo-white.png' : '/logo.png'"
            alt="AQUANOVA"
            :class=" globalTheme.name.value == 'dark' ? 'h-[160px]' : 'h-[160px]'"
          >
        </div>
      </RouterLink>

      <IconBtn
        class="d-block d-lg-none"
        @click="toggleIsOverlayNavActive(false)"
      >
        <VIcon icon="bx-x" />
      </IconBtn>
    </template>

    <template #vertical-nav-content>
      <NavItems />
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}

.app-logo {
  display: flex;
  align-items: center;
  column-gap: 0.75rem;

  .app-logo-title {
    font-size: 1.25rem;
    font-weight: 500;
    line-height: 1.75rem;
    text-transform: uppercase;
  }
}
</style>
