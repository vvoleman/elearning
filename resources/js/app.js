import Vue from "vue";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('emailver', require('./components/EmailVer.vue'));
Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('messenger',require('./components/Messenger'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('emailsel', require('./components/EmailSel.vue'));
const app = new Vue({
    el: '#app'
});
