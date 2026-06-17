import { defineConfig } from 'vite';

export default defineConfig({
  root: '.',
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        app: 'public/assets/js/app.js',
      },
    },
  },
  server: {
    host: 'localhost',
    port: 5173,
    strictPort: true,
  },
});