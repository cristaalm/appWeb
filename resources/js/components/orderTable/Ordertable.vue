<script setup>
import { computed } from 'vue'

const props = defineProps({
  headers: Array,
  items: Array,
  loading: Boolean,
  page: Number,
  perPage: Number,
  total: Number,
  sortBy: Array,
  search: String,
  activeSearch: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits([
  'update:search',
  'update:sortBy',
  'update:page',
  'update:perPage',
])

const totalPages = computed(() => Math.ceil(props.total / props.perPage))

const startItem = computed(() =>
  props.total === 0 ? 0 : (props.page - 1) * props.perPage + 1,
)

const endItem = computed(() =>
  Math.min(props.page * props.perPage, props.total),
)

const goToFirstPage = () => {
  if (props.page > 1) emit('update:page', 1)
}

const goToPreviousPage = () => {
  if (props.page > 1) emit('update:page', props.page - 1)
}

const goToNextPage = () => {
  if (props.page < totalPages.value) emit('update:page', props.page + 1)
}

const goToLastPage = () => {
  if (props.page < totalPages.value) emit('update:page', totalPages.value)
}
</script>

<template>
  <div>
    <VTextField
      v-if="activeSearch"
      :model-value="search"
      label="Buscar..."
      class="mb-2"
      append-icon="bx bx-search"
      @update:model-value="$emit('update:search', $event)"
    />

    <VDataTable
      :headers="headers"
      :items="items"
      :search="search"
      :items-per-page="perPage"
      :loading="loading"
      :sort-by="sortBy"
      class="elevation-1"
      show-current-page
      hide-default-footer
      no-data-text="No hay resultados disponibles"
      @update:sort-by="$emit('update:sortBy', $event)"
    >
      <template
        v-for="(_, name) in $slots"
        #[name]="slotProps"
      >
        <slot
          :name="name"
          v-bind="slotProps"
        />
      </template>

      <template #bottom>
        <div class="flex flex-wrap gap-2 justify-between items-center p-2 mt-4">
          <!-- Select de elementos por página -->
          <div class="flex gap-2 items-center">
            <span class="text-sm">Mostrar</span>
            <VSelect
              :model-value="perPage"
              :items="[5, 10, 25, 50, 100]"
              class="w-20"
              hide-details
              dense
              variant="outlined"
              @update:model-value="$emit('update:perPage', $event)"
            />
            <span class="text-sm">por página</span>
          </div>

          <!-- Contador de items -->
          <div class="text-sm">
            {{ startItem }}–{{ endItem }} de {{ total }}
          </div>

          <!-- Controles de paginado -->
          <div class="flex gap-1 items-center">
            <VBtn
              icon
              :disabled="page <= 1"
              size="small"
              variant="text"
              @click="goToFirstPage"
            >
              <VIcon icon="bx-first-page" />
            </VBtn>
            <VBtn
              icon
              :disabled="page <= 1"
              size="small"
              variant="text"
              @click="goToPreviousPage"
            >
              <VIcon icon="bx-chevron-left" />
            </VBtn>

            <span class="mx-2 text-sm">Página {{ page }} de {{ totalPages }}</span>

            <VBtn
              icon
              :disabled="page >= totalPages"
              size="small"
              variant="text"
              @click="goToNextPage"
            >
              <VIcon icon="bx-chevron-right" />
            </VBtn>
            <VBtn
              icon
              :disabled="page >= totalPages"
              size="small"
              variant="text"
              @click="goToLastPage"
            >
              <VIcon icon="bx-last-page" />
            </VBtn>
          </div>
        </div>
      </template>
    </VDataTable>
  </div>
</template>
