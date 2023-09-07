/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import ElementPlus from 'element-plus'
import { ZiggyVue } from 'ziggy';
import 'element-plus/dist/index.css'


// const app = createApp({});

createInertiaApp({
    resolve: name => {
      const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
      createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ElementPlus)
        .use(ZiggyVue)
        .mount(el)
    },
  })

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

// app.mount('#app');
