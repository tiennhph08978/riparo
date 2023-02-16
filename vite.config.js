import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path, { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/user/app.scss',
                'resources/sass/admin/app.scss',
                'resources/js/app.js',
                'resources/assets/js/jquery.min.js',
                'resources/assets/css/custom.css',
                'resources/assets/css/boostrap.min.css',
                'resources/js/admin/app.js',
            ],
            refresh: true,
        }),
    ],

    resolve: {
        alias: {
            '@': '/resources',
        },
    }
});
