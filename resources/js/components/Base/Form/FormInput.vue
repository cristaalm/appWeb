<script lang="ts">
export default {
  inheritAttrs: false
}
</script>

<script setup lang="ts">
import _ from 'lodash'
import { twMerge } from 'tailwind-merge'
import { computed, type InputHTMLAttributes, useAttrs, inject } from 'vue'
import { type ProvideFormInline } from './FormInline.vue'
import { type ProvideInputGroup } from './InputGroup/InputGroup.vue'

interface FormInputProps extends /* @vue-ignore */ InputHTMLAttributes {
  value?: InputHTMLAttributes['value']
  modelValue?: InputHTMLAttributes['value']
  formInputSize?: 'sm' | 'lg'
  rounded?: boolean
}

interface FormInputEmit {
  (e: 'update:modelValue', value: string): void
}

const props = defineProps<FormInputProps>()
const attrs = useAttrs()
const formInline = inject<ProvideFormInline>('formInline', false)
const inputGroup = inject<ProvideInputGroup>('inputGroup', false)

const computedClass = computed(() =>
  twMerge([
    'disabled:bg-[#013134]/50 disabled:cursor-not-allowed dark:disabled:bg-[#013134]/50 dark:disabled:border-transparent',
    '[&[readonly]]:bg-[#013134]/50 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-[#013134]/50 [&[readonly]]:dark:border-transparent',
    'transition duration-200 ease-in-out w-full text-sm border-[#013134]/50 shadow-sm rounded-md placeholder:text-[#013134]/80 focus:ring-4 focus:ring-[#013134] focus:ring-opacity-20 focus:border-[#013134] focus:border-opacity-40 dark:bg-[#013134]/50 dark:border-transparent dark:focus:ring-[#013134]/50 dark:focus:ring-opacity-50 dark:placeholder:text-[#013134]/80',
    props.formInputSize == 'sm' && 'text-xs py-1.5 px-2',
    props.formInputSize == 'lg' && 'text-lg py-1.5 px-4',
    props.rounded && 'rounded-full',
    formInline && 'flex-1',
    inputGroup &&
      'rounded-none [&:not(:first-child)]:border-l-transparent first:rounded-l last:rounded-r z-10',
    typeof attrs.class === 'string' && attrs.class
  ])
)

const emit = defineEmits<FormInputEmit>()

const localValue = computed({
  get() {
    return props.modelValue === undefined ? props.value : props.modelValue
  },
  set(newValue) {
    emit('update:modelValue', newValue)
  }
})
</script>

<template>
  <input
    :class="computedClass"
    :type="props.type"
    v-bind="_.omit(attrs, 'class')"
    v-model="localValue"
  />
</template>
