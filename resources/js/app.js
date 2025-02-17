import { createApp } from 'vue';  // Import Vue
import ProductsList from './components/ProductsList.vue';  // Import the Vue component

const app = createApp(ProductsList);  // Create the Vue app instance
app.mount('#app');  // Mount it to the HTML element with id="app"

