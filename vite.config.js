import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            paths: ["resources/views", "resources/js", "resources/css"], // Rutas a observar
        },
    }
});
