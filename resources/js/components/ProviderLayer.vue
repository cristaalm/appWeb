<script setup>
import { provide } from 'vue'
import useAllSistemas from '@/hooks/Sistemas/useAllSistemas'
import useGetAllDevices from '@/hooks/Devices/useGetAllDevices'
import useCatalogSystem from '@/hooks/Sistemas/useCatalogSystem'
import useLastMonth from '@/hooks/History/useLastMonth'

provide('sistemas', useAllSistemas())
provide('devices', useGetAllDevices())
provide('catalogSystem', useCatalogSystem())
provide('lastMonth', useLastMonth())
</script>

<template>
    <slot />
</template>
