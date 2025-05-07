import { useTheme } from 'vuetify'
import { useDarkModeStore } from '@/store/dark-mode'
import { computed, onMounted } from 'vue'

export function useThemeSwitcher() {
  const { name: themeName, global: globalTheme } = useTheme()
  const darkModeStore = useDarkModeStore()
  const themes = ['light', 'dark']

  function getNextThemeName() {
    const currentIndex = themes.indexOf(globalTheme.name.value)
    return themes[(currentIndex + 1) % themes.length]
  }

  function changeTheme() {
    globalTheme.name.value = getNextThemeName()
    darkModeStore.setDarkMode(globalTheme.name.value === 'dark')
  }

  const darkMode = computed({
    get: () => darkModeStore.darkMode,
    set: value => darkModeStore.setDarkMode(value),
  })

  onMounted(() => {
    // Set the initial theme
    globalTheme.name.value = darkMode.value ? 'dark' : 'light'
  })

  return {
    themeName,
    changeTheme,
    darkMode,
    globalTheme,
  }
}
