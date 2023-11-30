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
                'resources/js/orders/get_orders_dashboard.js',
                'resources/js/orders/get_orders.js',
                'resources/js/test/test.js',
                'resources/scss/orders/get_orders.scss',
                'resources/scss/workshop.scss'
            ],
            refresh: true,
        }),
    ],
});