<script setup>
import { provide } from 'vue'
import useAllSistemas from '@/hooks/Sistemas/useAllSistemas'
import useGetAllDevices from '@/hooks/Devices/useGetAllDevices'

provide('sistemas', useAllSistemas())
provide('devices', useGetAllDevices())
</script>

<template>
    <slot />
</template>
