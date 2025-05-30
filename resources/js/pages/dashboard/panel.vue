<script setup>
// import adminView from '@/pages/dashboard/panel/admin/adminView.vue'
import userView from '@/pages/dashboard/panel/user/userView.vue'

const user = JSON.parse(localStorage.getItem('user'))
const component = userView

</script>

<template>
  <component :is="component" />
</template>
