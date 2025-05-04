<script setup>
import ToastNotification from '@/components/Base/ToastNotification/'
</script>

<template>
  <VApp>
    <ToastNotification>
      <RouterView />
    </ToastNotification> 
  </VApp>
</template>
