import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        manifest: true,
        outDir: 'public/workshop/',
        cssCodeSplit: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/js/workshop.js',
                'resources/js/orders/dashboard.js',
                'resources/js/orders/create.js',
                'resources/js/test/test.js',
                'resources/scss/orders/create.scss',
                'resources/scss/workshop.scss'
            ],
            refresh: true,
        }),
    ],
});