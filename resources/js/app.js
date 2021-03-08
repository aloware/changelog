/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'

import VueToastr from "vue-toastr"
import moment from 'vue-moment'
import store from './store'

window.Vue = Vue;

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueToastr);
Vue.use(moment);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('changelogs-component', require('./components/ChangelogsComponent.vue').default);
Vue.component('changelog-component', require('./components/ChangelogComponent.vue').default);
Vue.component('changelog-form-component', require('./components/ChangelogFormComponent.vue').default);
Vue.component('published-changelog-component', require('./components/PublishedChangelogsComponent.vue').default);
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store : store,
});
