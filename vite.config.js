import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        AutoImport({
            dirs: [
                'resources/js/Stores/**',
                'resources/js/Composables/**',
            ],
            imports: [
                'vue'
            ]
         }),

        Components({
            dirs: [
                'resources/js/Components',
                'resources/js/Layouts'
            ],
            extensions: ['vue'],
            deep: true
         }),
    ],
});
