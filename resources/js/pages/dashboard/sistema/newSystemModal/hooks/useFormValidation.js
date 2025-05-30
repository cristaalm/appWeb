import { ref, watch } from 'vue'

export function useFormValidation(form) {
  const rfcRegex = /^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/i
  const telefonoRegex = /^\d{10}$/

  const razon_social_error = ref('')
  const nombre_comercial_error = ref('')
  const rfc_error = ref('')
  const telefono_error = ref('')

  watch(() => form.razon_social, val => {
    if (val.trim()) razon_social_error.value = ''
  })
  watch(() => form.nombre_comercial, val => {
    if (val.trim()) nombre_comercial_error.value = ''
  })
  watch(() => form.rfc, val => {
    if (rfcRegex.test(val.trim())) rfc_error.value = ''
  })
  watch(() => form.telefono, val => {
    if (telefonoRegex.test(val.trim())) telefono_error.value = ''
  })

  const validateForm = () => {
    let valid = true

    if (!form.razon_social.trim()) {
      razon_social_error.value = 'Este campo es obligatorio'
      valid = false
    }

    if (!form.nombre_comercial.trim()) {
      nombre_comercial_error.value = 'Este campo es obligatorio'
      valid = false
    }

    if (!rfcRegex.test(form.rfc.trim())) {
      rfc_error.value = 'RFC inválido. Debe tener formato correcto'
      valid = false
    }

    if (!telefonoRegex.test(form.telefono.trim())) {
      telefono_error.value = 'Teléfono inválido. Debe tener 10 dígitos'
      valid = false
    }

    return valid
  }

  return {
    razon_social_error,
    nombre_comercial_error,
    rfc_error,
    telefono_error,
    validateForm
  }
}
