import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',

                'resources/views/themes/gallerypuan/assets/css/main.css',
                'resources/views/themes/gallerypuan/assets/plugins/jqueryui/jquery-ui.css',

                'resources/views/themes/gallerypuan/assets/plugins/jqueryui/jquery-ui.min.js',
                'resources/views/themes/gallerypuan/assets/js/main.js',

                'resources/views/livewire/admin/assets/js/demo-theme.min.js',
                
            ],
            refresh: true,
        }),
    ],
    // --- TAMBAHKAN BLOK CSS INI UNTUK MEMBUNGKAM WARNING SASS ---
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: [
                    'legacy-js-api', 
                    'import', 
                    'global-builtin', 
                    'color-functions', 
                    'if-function'
                ],
            },
        },
    },
    // -----------------------------------------------------------
});