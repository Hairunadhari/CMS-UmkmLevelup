import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'
import fs from 'fs';

export default defineConfig({
  esbuild: {
    minify: false,
    minifySyntax: false
  },
  plugins: [
    laravel({
      input: [
        'resources/js/app.js'
      ]
      // valetTls: 'cms.test'
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  optimizeDeps: {
    exclude: [
      'vt-notifications', 'vue-tailwind', 'vue-tailwind/dist/vue-tailwind.css'
    ]
  },
  resolve: {
    alias: {
      '~': '/resources/js',
      '@': '/resources'
    }
  }
})
