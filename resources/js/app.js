import './bootstrap';
import '../css/app.css';
import '@formkit/themes/genesis'
import "vue-toastification/dist/index.css";

//Import Froala Editor 
import 'froala-editor/js/plugins.pkgd.min.js';
//Import third party plugins
import 'froala-editor/js/third_party/embedly.min';
import 'froala-editor/js/third_party/font_awesome.min';
import 'froala-editor/js/third_party/spell_checker.min';
import 'froala-editor/js/third_party/image_tui.min';
// Import Froala Editor css files.
import 'froala-editor/css/froala_editor.pkgd.min.css';
import 'froala-editor/css/froala_style.min.css';
//import vue css file
import 'vue-final-modal/style.css'

import VueEllipseProgress from 'vue-ellipse-progress';
import { createVfm } from 'vue-final-modal'
import { createApp, h } from 'vue';
import VueFroala from 'vue-froala-wysiwyg';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { plugin as formKitPlugin, defaultConfig } from '@formkit/vue';
import { createPinia } from 'pinia'
import config from '../../formkit.config.js';
import Toast from "vue-toastification";

const vfm = createVfm()
const pinia = createPinia()
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin: inertiaPlugin }) {
        return createApp({ render: () => h(App, props) })
            .use(inertiaPlugin)
            .use(ZiggyVue, Ziggy)
            .use(formKitPlugin, defaultConfig(config))
            .use(Toast, {})
            .use(pinia)
            .use(VueEllipseProgress)
            .use(vfm)
            .use(VueFroala)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
