import { createApp, h } from 'vue'
import { Head, Link, createInertiaApp } from '@inertiajs/vue3'
import "../css/app.css"
import Layout from "./layouts/Layout.vue"
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
createInertiaApp({
    title: (title) => `My App ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        let page = pages[`./pages/${name}.vue`]
        page.default.layout = page.default.layout || Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el)
    },
    progress: {
        delay: 250,
        color: '#29d',
        includeCSS: true,
        showSpinner: false,
    },
})