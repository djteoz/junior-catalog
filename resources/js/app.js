import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

createInertiaApp({
    resolve: (name) => import(`./Pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ElementPlus)
            .mount(el);
    },
});

InertiaProgress.init();
import "./bootstrap";
