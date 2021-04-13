require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import 'vue-trix';

import App from './Vue/Containers/App.vue'
import Dashboard from './Vue/Containers/Dashboard.vue'
import { routes } from './routes.js'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash, faEye } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueLazyload from 'vue-lazyload'

library.add(faTrash,faEye);

Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(VueRouter,VueLazyload);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes,
});

const app = new Vue({
    el: "#app",
    components: {App},
    router,
});