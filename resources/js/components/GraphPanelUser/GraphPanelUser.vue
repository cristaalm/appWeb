<script setup>
import { useTheme } from 'vuetify'

import PHImage from '@images/sensors/PH.png?url'
import CEImage from '@images/sensors/CE.png?url'
import DHT11 from '@images/sensors/DHT11.png?url'
import TempImage from '@images/sensors/Temp.png?url'
import DistImage from '@images/sensors/Dist.png?url'

import LoadingIcon from '@/components/Base/LoadingIcon'

import { hexToRgb } from '@layouts/utils'
import { computed, inject } from 'vue'

const {
  selectedTypeDevice,
  changeTypeDevice
} = inject('selectedDevice')

const props = defineProps({
  height: {
    type: Number,
    default: 500,
  },
})

const vuetifyTheme = useTheme()

const { data, profitLoss, current, loading, loadLastMonthData } = inject("lastMonth");
import { ref, watch } from 'vue';

const currentTab = ref(selectedTypeDevice);

// Series y categorías dinámicas
const dynamicSeries = ref([{ data: [] }]);
const dynamicCategories = ref([]);

// Formateador de fechas amigable
function formatDate(dateString) {
  const date = new Date(dateString.replace(' ', 'T'));
  const options = { day: '2-digit', month: 'short'};
  // Ejemplo: "13 May 23:26"
  return date.toLocaleString('es-MX', options).replace(',', '');
}

// Cargar datos cuando cambia el tab
watch(currentTab, (newVal) => {
  changeTypeDevice(newVal);
  loadLastMonthData(newVal);
}, { immediate: true });

// Actualizar series y categorías cuando llegan datos nuevos
watch(data, (newData) => {
  if (Array.isArray(newData) && newData.length > 0) {
    // Ordenar por fecha (opcional, si no vienen ordenados)
    const sorted = [...newData].sort((a, b) => new Date(a.fecha_ingreso) - new Date(b.fecha_ingreso));
    dynamicSeries.value = [{ data: sorted.map(d => Number(d.valor)) }];
    dynamicCategories.value = sorted.map(d => formatDate(d.fecha_ingreso));
  } else {
    dynamicSeries.value = [{ data: [] }];
    dynamicCategories.value = [];
  }
}, { immediate: true });

const dataTaps = {
  5: {
    value: 5,
    avatar: DistImage,
    title: 'Sensor de distancia',
    color: '#12b7ef',
  },
  2: {
    value: 2,
    avatar: PHImage,
    title: 'Sensor de PH',
    color: '#62b1ad',
  },
  1: {
    value: 1,
    avatar: CEImage,
    title: 'Sensor de conductividad',
    color: '#2ecc71',
  },
  3: {
    value: 3,
    avatar: DHT11,
    title: 'Sensor de temperatura y humedad',
    color: '#ec9c56',
  },
  6: {
    value: 6,
    avatar: DHT11,
    title: 'Sensor de humedad',
    color: '#1e89cf',
  },
  4: {
    value: 4,
    avatar: TempImage,
    title: 'Sensor de temperatura',
    color: '#3c9a9b',
  },
}

const tabData = computed(() => {
  return dataTaps[currentTab.value]
})

const chartConfig = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors;
  const variableTheme = vuetifyTheme.current.value.variables;
  const disabledTextColor = `rgba(${ hexToRgb(String(currentTheme['on-surface'])) },${ variableTheme['disabled-opacity'] })`;
  const borderColor = `rgba(${ hexToRgb(String(variableTheme['border-color'])) },${ variableTheme['border-opacity'] })`;
  return {
    chart: {
      parentHeightOffset: 0,
      toolbar: { show: false },
    },
    dataLabels: { enabled: false },
    stroke: {
      width: 3,
      curve: 'smooth',
    },
    grid: {
      strokeDashArray: 4.5,
      borderColor,
      padding: {
        left: 0,
        top: -20,
        right: 11,
        bottom: 7,
      },
    },
    fill: {
      type: 'gradient',
      gradient: {
        opacityTo: 0.25,
        opacityFrom: 0.5,
        stops: [0, 95, 100],
        shadeIntensity: 0.6,
        colorStops: [[
          { offset: 0, opacity: 0.4, color: tabData.value.color },
          { offset: 100, opacity: 0.2, color: currentTheme.surface },
        ]],
      },
    },
    theme: {
      monochrome: {
        enabled: true,
        shadeTo: 'light',
        shadeIntensity: 1,
        color: tabData.value.color,
      },
    },
    xaxis: {
      axisTicks: { show: false },
      axisBorder: { show: false },
      categories: dynamicCategories.value.length > 0 ? dynamicCategories.value : [''],
      offsetY: 20,
      offsetX: -24,
      labels: {
        style: {
          fontSize: '14px',
          colors: disabledTextColor,
          fontFamily: 'Public Sans',
        },
      },
    },
    yaxis: {
      show: true,
      labels: {
        style: {
          fontSize: '14px',
          colors: disabledTextColor,
          fontFamily: 'Public Sans',
        },
      },
      tickAmount: 4,
    },
    markers: {
      size: 8,
      strokeWidth: 6,
      strokeOpacity: 1,
      offsetX: -10,
      hover: { size: 8 },
      colors: ['transparent'],
      strokeColors: 'transparent',
      discrete: [{
        size: 8,
        seriesIndex: 0,
        fillColor: '#fff',
        strokeColor: tabData.value.color,
        dataPointIndex: dynamicSeries.value[0].data.length - 1,
      }],
    },
  };
});
</script>

<template>
    <VCardText>
      <VTabs
        v-model="currentTab"
        class="v-tabs-pill"
      >
        <VTab
          v-for="{ value, title, color } in dataTaps"
          :key="value"
          :value="Number(value)"
          :color="color"
          :variant="tabData.value === Number(value) ? 'tonal' : 'text'"
          :disabled="loading"
          :style="{ color: tabData.value === Number(value)? `${dataTaps[value].color} !important` : '' }"
          class="dark:!text-[#49b8b6] !text-[#4da3a3]"
          :loading="loading && currentTab === Number(value)"
        >
          {{ title }}
        </VTab>
      </VTabs>
    </VCardText>

    <VCardText class="gap-3 d-flex align-center" :class="loading ? 'opacity-50' : ''">
      <VAvatar
        size="48"
        rounded
        class="!bg-white"
        :image="tabData.avatar"
      />

      <div>
        <p class="mb-0">
          {{ tabData.title }}
        </p>
        <div class="gap-2 d-flex align-center">
          <h6 class="text-h6">
            {{ current }}
          </h6>
          <span
            class="text-sm"
            :class="profitLoss > 0 ? 'text-success' : 'text-error'"
          >
            <VIcon
              v-if="profitLoss > 0"
              size="24"
              icon="bx-chevron-up"
            />
            <VIcon
              v-else
              size="24"
              icon="bx-chevron-down"
            />
            {{ profitLoss }}
          </span>
        </div>
      </div>
    </VCardText>

    <VCardText style="position: relative; min-height: 260px;">
      <!-- Overlay de carga -->
      <div
        v-if="loading"
        class="justify-center loading-overlay d-flex flex-column align-center"
        :style="{
          position: 'absolute',
          left: 0,
          top: 0,
          width: '100%',
          height: '100%',
          zIndex: 2,
          background: vuetifyTheme.current.value.dark ? 'transparent' : 'transparent',
        }"
      >
        <span
          :style="{
            fontSize: '2.2rem',
            fontWeight: 'bold',
            height: '5rem',
            color: vuetifyTheme.current.value.dark ? '#fff' : '#6dbab9',
            textShadow: vuetifyTheme.current.value.dark ? '0 2px 8px #000' : '0 2px 8px #fff',
            letterSpacing: '0.05em',
          }"
        >
          <LoadingIcon icon="ball-triangle" :fillColor="tabData.color"/>
        </span>
      </div>
      <!-- Gráfica con opacidad -->
      <div :style="{ opacity: loading ? 0.3 : 1, transition: 'opacity 0.2s' }">
        <VueApexCharts
          type="area"
          class="!text-black"
          :height="height"
          :options="chartConfig"
          :series="dynamicSeries"
        />
      </div>
    </VCardText>
</template>
