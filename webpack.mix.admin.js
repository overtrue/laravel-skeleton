const path = require('path')
const fs = require('fs-extra')
const mix = require('laravel-mix')
require('laravel-mix-versionhash')
const tailwindcss = require('tailwindcss')
const purgecss = require('@fullhuman/postcss-purgecss')({
  // Specify the paths to all of the template files in your project
  content: [
    './resources/**/*.html',
    './resources/**/*.vue',
    './resources/**/*.jsx'
    // etc.
  ],

  // Include any special characters you're using in this regular expression
  defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || [],
  whitelist: ['html', 'body'],
  // 不处理的样式
  // element-ui, mdi, nprogress
  whitelistPatternsChildren: [/^el-/, /^v-/, /^mdi/, /^nprogress/, /^vxe/],
})

// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix
  .js('resources/admin/js/app.js', 'public/dist/admin/js')
  .sass('resources/admin/sass/app.scss', 'public/dist/admin/css')
  .options({
    processCssUrls: true,
    extractVueStyles: true,
    postCss: [tailwindcss('./tailwind.config.js'), ...(process.env.NODE_ENV === 'production' ? [purgecss] : [])]
  })

if (mix.inProduction()) {
  mix
    // .extract() // Disabled until resolved: https://github.com/JeffreyWay/laravel-mix/issues/1889
    // .version() // Use `laravel-mix-versionhash` for the generating correct Laravel Mix manifest file.
    .versionHash()
} else {
  mix.sourceMaps()
}

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/admin/js')
    }
  },
  output: {
    chunkFilename: 'dist/admin/js/[chunkhash].js',
    path: mix.config.hmr ? '/' : path.resolve(__dirname, './public/')
  }
})
