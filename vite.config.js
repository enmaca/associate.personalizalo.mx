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
                    'resources/js/plugins/choices.js',
                    'resources/js/plugins/toastify.js',
                    'resources/js/plugins/tomselect.js',
                    'resources/scss/bootstrap.scss',
                    'resources/scss/tomselect.scss',
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
