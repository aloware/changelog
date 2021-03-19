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

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'

import VueToastr from "vue-toastr"
import moment from 'vue-moment'
import store from './store'
import VueConfirmDialog from 'vue-confirm-dialog'
import VueClipboard from 'vue-clipboard2'

import './filters'
window.Vue = Vue;

Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

library.add(fas, fab, far)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.config.productionTip = false

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueToastr);
Vue.use(moment);
Vue.use(VueClipboard)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('changelogs-component', require('./components/changelog-list.vue').default);
Vue.component('changelog-component', require('./components/changelog.vue').default);
Vue.component('changelog-form-component', require('./components/changelog-form.vue').default);

Vue.component('published-changelog-page-list-component', require('./components/published-changelog-page-list.vue').default);

Vue.component('published-changelog-widget-component', require('./components/published-changelog-widget.vue').default);
Vue.component('published-changelog-widget-list-component', require('./components/published-changelog-widget-list.vue').default);

Vue.component('widget-settings-component', require('./components/settings/widget-settings.vue').default);
Vue.component('page-settings-component', require('./components/settings/page-settings.vue').default);
Vue.component('categories-component', require('./components/category-list.vue').default);
Vue.component('category-component', require('./components/category.vue').default);
Vue.component('category-form-component', require('./components/category-form.vue').default);

Vue.component('project-settings-component', require('./components/settings/project-settings.vue').default);
Vue.component('relative-time-component', require('./components/relative-time.vue').default);
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
