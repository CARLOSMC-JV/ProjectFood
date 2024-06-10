// import './bootstrap';
import '../css/theme.min.css';
import '../css/simplebar.min.css';
import '../css/nouislider.min.css';
import '../css/app.css';
import '../css/estilos.css';
import '../css/list_products.css';
import '../css/category_product.css';
import '../css/slideshow.css';
import '../css/modal.css';
import '../css/navbar.css';
import '../css/product_detail.css';
import '../css/list_category.css';
import '../css/cart_shop.css';
import 'swiper/css';
// import '../js/global_components/global_component.js';

// import 'bootstrap';
// import 'bootstrap/dist/css/bootstrap.min.css';

// import '../../resources/fonts/createx-icons.ttf';
import { useToast } from '../js/toast/toast.js';

import { createPinia } from 'pinia';
import VueSplide from '@splidejs/vue-splide';
import { Swiper, SwiperSlide } from 'swiper/vue';

// import { createRouter, createWebHistory } from 'vue-router';
// import routes from '@/routes/routes.js';


import AsistanChef from "@/ComponentsCustom/AsistanChef.vue";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = import.meta.env.VITE_APP_NAME || '';
import '@fortawesome/fontawesome-free/css/all.min.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { faUser, faBars, faTimes } from '@fortawesome/free-solid-svg-icons';

library.add(faCoffee);
library.add(faUser);
library.add(faBars);
library.add(faTimes);
// const router = createRouter({
//     history: createWebHistory(),
//     routes,
//   });

createInertiaApp({
    title: (title) => `${title} `,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

        // return createApp({ render: () => h(App, props) })
        //     .use(plugin)
        //     .use(ZiggyVue, Ziggy)
        //     .mount(el);

        const app = createApp({ render: () => h(App, props )});
        app.use(plugin);
        app.use(ZiggyVue, Ziggy);

        const pinia = createPinia();
        app.use(pinia);
        useToast(app);

        app.use( VueSplide );
        app.use( Swiper );
        app.use( SwiperSlide );
        // app.use(router);
        app.directive('toggle-navbar', {
            mounted(el) {
                el.addEventListener('click', () => {
                    document.body.classList.toggle('show-navbar');
                });
            }
        });

        app.directive('toggle-navbar-delete', {
            mounted(el) {
                el.addEventListener('click', () => {
                    document.body.classList.delete('show-navbar');
                });
            }
        });
        app.directive('click-outside', {
            // Enlazamos el elemento con la función
            beforeMount(el, binding) {
              el.clickOutsideEvent = function (event) {
                // Verifica si el evento de clic ocurrió fuera del elemento y su descendencia
                if (!(el === event.target || el.contains(event.target))) {
                  // Ejecuta la función vinculada cuando se hace clic fuera del elemento
                  binding.value();
                }
              };
              // Agrega un escuchador de eventos al documento
              document.addEventListener('click', el.clickOutsideEvent);
            },
            unmounted(el) {
              // Limpia el escuchador de eventos cuando el componente se desmonta
              document.removeEventListener('click', el.clickOutsideEvent);
            },
          });
        app.component('font-awesome-icon', FontAwesomeIcon);
        app.component('AsistanChef', AsistanChef);

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
