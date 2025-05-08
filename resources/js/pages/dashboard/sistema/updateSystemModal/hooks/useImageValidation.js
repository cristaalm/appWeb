import { ref } from 'vue'

export function useImageValidation(form) {
  const imageError = ref('')

  const validateImage = (file) => {
    if (!file) {
      imageError.value = ''
      return true
    }

    const validTypes = ['image/jpeg', 'image/png', 'image/webp']
    const maxSize = 2 * 1024 * 1024 // 2MB

    if (!validTypes.includes(file.type)) {
      imageError.value = 'Formato no válido. Usa JPG, PNG o WEBP.'
      return false
    }

    if (file.size > maxSize) {
      imageError.value = 'La imagen excede 2MB.'
      return false
    }

    imageError.value = ''
    return true
  }

  return {
    imageError,
    validateImage
  }
}
