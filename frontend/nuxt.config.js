export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'frontend',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '~/assets/css/style'
  ],

  router: {
    middleware: [
      'clearValidationErrors',
      'auth',
    ]
  },

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    './plugins/mixins/validation',
    './plugins/mixins/user',
    './plugins/axios',
    './plugins/element-ui.js',
    './plugins/vue-color',
  ],

  env: {
    baseUrl: process.env.API_URL,
  },

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
    '@nuxtjs/tailwindcss',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/pwa',
    '@nuxtjs/dotenv',
  ],

  auth: {
    strategies: {
      local: {
        token: {
          property: 'token',
          required: true,
          type: 'Bearer'
        },
        user: {
          property: 'data',
          autoFetch: true
        },
        endpoints: {
          login: { url: '/auth/login', method: 'post', propertyName: 'token', redirect: 'index' },
          logout: { url: '/auth/logout', method: 'post' },
          refresh: { url: '/auth/refresh', method: 'post' },
          user: { url: '/me', method: 'get', propertyName: 'data' },
        },
      },
    },
    redirect: {
      login: '/',
      logout: '/',
      callback: '/',
      home: '/home'
    },
    watchLoggedIn: true,
    rewriteRedirects: true
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    baseUrl: process.env.API_URL,
  },

  // PWA module configuration: https://go.nuxtjs.dev/pwa
  // pwa: {
  //   manifest: {
  //     lang: 'en'
  //   }
  // },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  vue: {
    config: {
      devtools: true,
      productionTip: false,
    },
  },

  server: {
    host: '0.0.0.0',
    port: 8080,
  }
}
