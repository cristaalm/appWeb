<script setup>
import { provide } from 'vue'
import useAllSistemas from '@/hooks/Sistemas/useAllSistemas'
import useGetAllDevices from '@/hooks/Devices/useGetAllDevices'
import useCatalogSystem from '@/hooks/Sistemas/useCatalogSystem'

provide('sistemas', useAllSistemas())
provide('devices', useGetAllDevices())
provide('catalogSystem', useCatalogSystem())
</script>

<template>
    <slot />
</template>
