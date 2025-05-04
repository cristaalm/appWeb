<script setup>
import { useTheme } from 'vuetify'

const { global } = useTheme()

const authProviders = [
  {
    icon: 'bxl-facebook',
    color: '#4267b2',
    colorInDark: '#4267b2',
    link: 'https://www.facebook.com/people/Velor-Inovacion/pfbid032AG5hYHvAKNbzC3nh8tbc1o64F785PpzxjVG4ZvWmXDjewaZXRaFVW3R2y9Ls6QKl/',
  },
  {
    icon: 'bxl-instagram',
    color: '#e1306c',
    colorInDark: '#e1306c',
    link: 'https://www.instagram.com/velorinnovation.mx',
  },
  {
    icon: 'bxl-youtube',
    color: '#ff0000',
    colorInDark: '#ff0000',
    link: 'https://www.youtube.com/channel/UCgoOSKHmhwaPFTVaXbWQI0g',
  },
  {
    icon: 'bxl-github',
    color: '#333',
    colorInDark: '#333',
    link: 'https://github.com/velor-innovation',
  },
]
</script>

<template>
  <a 
    v-for="link in authProviders"
    :key="link.icon"
    :href="link.link" 
    target="_blank" 
    rel="noopener noreferrer"
  >
    <VBtn
      
      :icon="link.icon"
      variant="text"
      :color="global.name.value === 'dark' ? link.colorInDark : link.color"
    />
  </a>
</template>
