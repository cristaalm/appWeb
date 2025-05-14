import App from '@/App.vue'
import { registerPlugins } from '@core/utils/plugins'
import { createApp } from 'vue'

// Directives
import letterOnly from './directives/letterOnly.js'
import numberOnly from './directives/numberOnly.js'

// Styles
import '@core-scss/template/index.scss'
import '@layouts/styles/index.scss'
import '@styles/styles.scss'
import './main.css' // tailwindcss
import '@/assets/css/input.css' // Import custom styles

// Create vue app
const app = createApp(App)


// Register plugins
registerPlugins(app)

// Directives
app.directive('letter-only', letterOnly)
app.directive('number-only', numberOnly)

// Mount vue app
app.mount('#app')
