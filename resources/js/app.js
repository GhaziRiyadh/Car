import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { ZiggyVue } from 'ziggy';
import Notifications from '@kyvg/vue3-notification'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
// import VueSpinners from 'vue-spinners'




const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const myapp = createApp({ render: () => h(app, props) });
        myapp.use(plugin)
        myapp.use(ZiggyVue, Ziggy)
        myapp.use(Notifications)
        // myapp.use(VueSpinners)
        // myapp.component('Datepicker', Datepicker);
        myapp.mount(el);
        return myapp;
    },
});

InertiaProgress.init({ color: '#4B5563' });

function errorNotification() {
    return this.$notify({
        title: 'Error',
        text: 'حدث خطاء ما!',
        type: 'warn',
    })
}

function successNotification() {
    return this.$notify({
        title: 'تم',
        text: 'كل شيئ على مايرام',
        type: 'success',
    })
}
