import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Login
                'resources/css/app.css',
                'resources/js/app.js',

                // Dashboard
                'resources/css/style.css',
                'resources/js/index.js',
            ],
            refresh: true,
        }),
    ],
});