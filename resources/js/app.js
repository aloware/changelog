require('./bootstrap');

import Vue from 'vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueToastr from "vue-toastr"
import moment from 'vue-moment'
import store from './store'

import Changelogs from "./components/Changelogs";

window.Vue = Vue;

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueToastr);
Vue.use(moment);

//Vue.component('changelogs-component', Changelogs);
Vue.component('changelogs-component', require('./components/Changelogs').default);

const app = new Vue({
    el: '#app',
    store
});
