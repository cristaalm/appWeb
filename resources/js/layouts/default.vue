<script setup>
import DefaultLayoutWithVerticalNav from './components/DefaultLayoutWithVerticalNav.vue'
import ProviderLayer from '@/components/ProviderLayer.vue'
</script>

<template>
  <ProviderLayer>
    <DefaultLayoutWithVerticalNav>
      <RouterView />
    </DefaultLayoutWithVerticalNav>
  </ProviderLayer>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";
</style>
