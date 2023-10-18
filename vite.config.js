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
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/orders/root.js',
                'resources/js/orders/root_livewire.js',
                'resources/js/orders/create.js'
            ],
            refresh: true,
        }),
    ],
});