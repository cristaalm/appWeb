<script setup>
import ReportBarChart5 from "@/components/GraphPanelUser";

</script>
<template>
  <VCardText class="flex flex-col col-span-12 !p-5">

    <div class="flex flex-col gap-2 justify-between items-start">
      <h1 class="text-3xl font-semibold text-gray-800 dark:text-slate-200">
          <span class="dark:text-slate-200">Información General del Sistema</span> 
      </h1>
      <p class="mt-1 text-sm text-gray-500 dark:text-slate-300">
        Promedio de por dia del sistema
      </p>
    </div>

    <div class="mt-7 mb-1" id="barraDonaciones">
      <ReportBarChart5 :height="400" />
    </div>

  </VCardText>
</template>

