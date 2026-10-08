import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

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
    // 本番環境（Railway）でのCSS・JSの配信ルートのバグを強制解決する設定
        server: {
            hmr: {
                host: 'fridge-mind-production.up.railway.app',
                protocol: 'wss'
            }
        }
});