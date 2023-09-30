const vite = require('vite');
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default vite.defineConfig({
    build: {
        manifest: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
    },
    plugins: [
        laravel(
            {
                input: [
                    'resources/js/app.js',
                    'resources/js/bootstrap.js',
                    'resources/js/layout.js',
                    'resources/js/plugins.js',
                    'resources/js/datatables.js',
                    'resources/js/uxmal/choices.js',
                    'resources/js/uxmal/toastify.js',
                    'resources/js/uxmal/tomselect.js',
                    'resources/js/uxmal/list.js',
                    'resources/scss/bootstrap.scss',
                    'resources/scss/datatables.scss',
                    'resources/scss/uxmal/tomselect.scss',
                    'resources/scss/uxmal/choices.scss',
                    'resources/scss/icons.scss',
                    'resources/scss/app.scss',
                    'resources/scss/custom.scss'
                ],
                refresh: true
            }
        ),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/fonts',
                    dest: ''
                },
                {
                    src: 'resources/images',
                    dest: ''
                },
                {
                    src: 'resources/js',
                    dest: ''
                },
                {
                    src: 'resources/json',
                    dest: ''
                },
                {
                    src: 'resources/libs',
                    dest: ''
                },
            ]
        }),
    ],
});
