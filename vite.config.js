import { defineConfig } from 'vite';
import { laravel } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // サーバー上での配信エラーを防止する設定
    base: './',
});