<script setup>
import OrderTable from '@/components/orderTable/'
import { useAllHistory } from '@/hooks/History/useGetAllHistory'
import Litepicker from '@/components/Base/Litepicker'
import { inject } from 'vue'

const {
  selectedTypeDevice,
} = inject('selectedDevice')

const {
  history,
  total,
  loading,
  page,
  perPage,
  sortBy,
  loadHistory,
  fecha,
} = useAllHistory(selectedTypeDevice)



const headers = [
  { title: 'Dispositivo', key: 'id_dispositivo', sortable: false },
  { title: 'Valor', key: 'valor', sortable: false },
  { title: 'Fecha', key: 'fecha_ingreso', sortable: true },
]

const dataTaps = {
  5: {
    value: 5,
    title: 'Sensor de distancia',
  },
  2: {
    value: 2,
    title: 'Sensor de PH',
  },
  1: {
    value: 1,
    title: 'Sensor de conductividad',
  },
  3: {
    value: 3,
    title: 'Sensor de temperatura y humedad',
  },
  6: {
    value: 6,
    title: 'Sensor de humedad',
  },
  4: {
    value: 4,
    title: 'Sensor de temperatura',
  },
}

</script>

<template>
  <VCardText class="flex flex-col col-span-12 !p-5 space-y-6">
    <div class="flex flex-col gap-4 justify-between items-start sm:flex-row sm:items-center">

      <div class="flex flex-row gap-3 justify-end items-center w-full">
        <VBtn
          variant="text"
          class="!text-gray-500 hover:!text-blue-600 dark:!text-gray-300 dark:hover:!text-white transition-all duration-200"
          icon
          title="Refrescar"
          @click="loadHistory"
        >
          <VIcon
            icon="bx-refresh"
            class="text-xl"
          />
        </VBtn>

        <div class="flex flex-row gap-2">
          <Litepicker 
            v-model="fecha" 
            :options="{
              autoApply: false,
              singleMode: false,
              numberOfColumns: 2,
              numberOfMonths: 2,
              showWeekNumbers: true,
              dropdowns: {
                  months: true,
                  years: true
              },
              format: 'DD/MM/YYYY'
            }" 
            class="block w-full !bg-slate-200 dark:!text-slate-200 dark:read-only:!bg-[#114d50] px-4 py-2 dark:placeholder:!text-slate-400 text-center !cursor-pointer"
            readonly />
        </div>
        

      </div>
    </div>

    <OrderTable
      :headers="headers"
      :items="history"
      :loading="loading"
      :page="page"
      :per-page="perPage"
      :total="total"
      :sort-by="sortBy"
      :active-search="false"
      @update:page="page = $event"
      @update:per-page="perPage = $event"
      @update:sort-by="sortBy = $event"
    >
      <template #item.id_dispositivo="{ item }">
        <span class="flex flex-row items-center text-lg font-medium text-gray-500 dark:text-gray-300">
          {{ dataTaps[item.id_dispositivo].title }}
        </span>
      </template>
      <template #item.valor="{ item }">
        <span class="flex flex-row justify-start items-center w-full text-lg font-medium text-gray-500 dark:text-gray-300">
          <span class="px-2 py-1 text-lg text-center text-black rounded min-w-20 bg-slate-200" >{{ item.valor }}</span>
        </span>
      </template>
      <template #item.fecha_ingreso="{ item }">
        <!-- formateamos la fecha -->
         <span class="flex flex-row gap-2 items-center text-lg font-medium text-gray-500 dark:text-gray-300">
          {{ new Date(item.fecha_ingreso).toLocaleString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit'}) }}
          <VIcon
            icon="bx-calendar"
            class="text-lg"
          />
         </span>
      </template>
    </OrderTable>
  </VCardText>
</template>
