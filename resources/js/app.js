import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

const pages = import.meta.glob("./Pages/**/*.vue");

createInertiaApp({
    resolve: (name) => {
        const path = `./Pages/${name}.vue`;
        const importer = pages[path];
        if (!importer) {
            throw new Error(`Unknown page: ${name}`);
        }
        return importer();
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(ElementPlus);
        app.component("InertiaLink", Link);
        app.mount(el);
    },
});

InertiaProgress.init();
