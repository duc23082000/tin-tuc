import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import CKEditor from '@ckeditor/ckeditor5-vue';

import { createPinia } from 'pinia'
const pinia = createPinia()


import VueSocialauth from 'vue-social-auth'
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faUserSecret, 
    faThumbsUp, 
    faShareFromSquare, 
    faComment, 
    faBell, 
    faMagnifyingGlass, 
    faBars, 
    faUser, 
    faGears, 
    faArrowRightFromBracket, 
    faAngleRight
} from '@fortawesome/free-solid-svg-icons'

import { faGoogle } from '@fortawesome/free-brands-svg-icons';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

/* add icons to the library */
library.add(
    faUserSecret, 
    faThumbsUp, faShareFromSquare, 
    faComment, 
    faBell,
    faMagnifyingGlass,
    faBars,
    faUser,
    faGears,
    faArrowRightFromBracket,
    faAngleRight,
    faGoogle,
)

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ElementPlus)
            .use(CKEditor)
            .use(pinia)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


