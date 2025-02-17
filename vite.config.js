import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],  // Ensure input points to the right files
            refresh: true,
        }),
        vue(),  // Include Vue plugin
    ],
});

