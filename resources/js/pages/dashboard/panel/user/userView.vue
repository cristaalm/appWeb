<script setup>
import GraphView from "@/components/dashboard/user/GraphView";
import TableHistoryView from "@/components/dashboard/user/TableHistoryView";
import {ref, provide} from 'vue'

const selectedTypeDevice = ref(1)

const changeTypeDevice = (value) => {
  selectedTypeDevice.value = value
}

provide('selectedDevice', {
  selectedTypeDevice,
  changeTypeDevice
})

</script>

<template>
  <div>
        <div class="grid grid-cols-12 gap-x-6 gap-y-10">
            <div class="col-span-12">
                <div class="flex flex-col gap-8">
                    <!-- Contenedor de cards -->
                    <VCard class="grid grid-cols-12 gap-5 mt-3">
                      <GraphView/>
                      <TableHistoryView/>
                    </VCard>
                </div>
            </div>
        </div>
    </div>
</template>
