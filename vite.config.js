import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('element-plus')) return 'vendor-element-plus';
                        if (id.includes('vue')) return 'vendor-vue';
                        return 'vendor';
                    }
                    // keep default for other modules
                    return undefined;
                }
            }
        },
        chunkSizeWarningLimit: 1200
    }
});
