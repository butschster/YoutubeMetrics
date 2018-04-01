require('dotenv').config();

module.exports = {
    /*
    ** Headers of the page
    */
    head: {
        title: '%s - BotsMeter',
        meta: [
            {charset: 'utf-8'},
            {name: 'viewport', content: 'width=device-width, initial-scale=1'},
            {hid: 'description', name: 'description', content: 'BotsMeter Frontend'}
        ],
        link: [
            {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
        ]
    },

    router: {
        middleware: [
            'clearValidationErrors'
        ]
    },

    plugins: [
        '~/plugins/Http/axios',
        '~/plugins/Http/router',
        '~/plugins/i18n',
        '~/plugins/mixins/user',
        '~/plugins/mixins/validation'
    ],

    modules: [
        '@nuxtjs/dotenv',
        '@nuxtjs/axios',
        '@nuxtjs/auth',
    ],

    axios: {
        baseUrl: process.env.API_URL
    },

    auth: {
        endpoints: {
            login: {
                url: 'login', method: 'post', propertyName: 'meta.token'
            },
            user: {
                url: 'me', method: 'get', propertyName: 'data'
            },
            logout: {
                url: 'logout', method: "post"
            }
        }
    },

    /*
    ** Customize the progress bar color
    */
    loading: {color: '#3B8070'},

    /*
    ** Build configuration
    */
    build: {
        vendor: [
            'axios', 'popper.js', 'bootstrap', 'lodash'
        ],

        /*
        ** Run ESLint on save
        */
        extend(config, {isDev, isClient}) {
            if (isDev && isClient) {
                config.module.rules.push({
                    enforce: 'pre',
                    test: /\.(js|vue)$/,
                    loader: 'eslint-loader',
                    exclude: /(node_modules)/
                })
            }
        },

        css: [
            '@assets/sass/app.scss'
        ]
    },

    css: [
        '@assets/sass/app.scss'
    ]
}
