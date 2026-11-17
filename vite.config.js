import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Aset halaman SKEM (tanpa Tailwind/preflight agar tampilan tidak berubah)
                'resources/css/skem/base.css',
                'resources/css/skem/admin-login.css',
                'resources/css/skem/index.css',
                'resources/css/skem/pantau-mahasiswa.css',
                'resources/css/skem/ajukan.css',
                'resources/css/skem/pantau-admin.css',
                'resources/css/skem/error.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
