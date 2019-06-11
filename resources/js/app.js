import Vue from "vue";
import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import Datetime from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
import Snotify, { SnotifyPosition } from 'vue-snotify';
import 'vue-snotify/styles/material.css';

require('./bootstrap');

Vue.use(VeeValidate);
Vue.use(BootstrapVue);
Vue.use(Datetime);

const options = {
    toast: {
        position: SnotifyPosition.centerTop
    }
}
Vue.use(Snotify,options)

window.Vue = require('vue');
Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            // here I check that click was outside the el and his childrens
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});

const dict = {
    custom: {
        email: {
            required: 'Email nesmí být prázdný!',
            email: 'Toto není email!'
        },
        name: {
            required: 'Název nesmí být prázdný!',
            min: 'Název je příliš krátký!',
            max: 'Název je příliš dlouhý!',
        },
        shortcut: {
            required: 'Zkratka musí být vyplněna!',
            min: 'Zkratka musí být min. 4 znaky dlouhá!',
            max: 'Zkratka může být max. 8 znaků dlouhá!',
            regex: 'Zkratka obsahuje nepovolované znaky!'
        }
    }
}; //err messages

Vue.component('emailver', require('./components/EmailVer.vue'));
Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('messenger',require('./components/Messenger'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('emailsel', require('./components/EmailSel.vue'));
Vue.component('hideable', require('./components/Hideable.vue'));
Vue.component('newcourse', require('./components/course/NewCourse.vue'));
Vue.component('scchecker', require('./components/ShortcutChecker.vue'));
Vue.component('editlectors', require('./components/course/EditLectors.vue'));
Vue.component('editgroups',require('./components/course/EditGroups.vue'));
Vue.component('ecset',require('./components/course/EditSettings'));
Vue.component('editstudent',require('./components/group/editStudents'));
Vue.component('newgroup',require('./components/group/newGroup'));
Vue.component('moduleview',require('./components/module/ModuleViewer.vue'));
Vue.component('modulecreate',require('./components/module/ModuleCreater.vue'));
Vue.component('alert',require('./components/Alert.vue'));
Vue.component('showquiz',require('./components/quiz/Quiz.vue'));
Vue.component('newquiz',require('./components/quiz/NewQuiz'));
Vue.component('passmanage',require('./components/quiz/PassManage.vue'));
Vue.component('openresults',require('./components/quiz/OpenResults.vue'));
Vue.component('opensinteractive',require('./components/OpensInteractive.vue'));

const app = new Vue({
    el: '#app',
    mounted(){
        this.$validator.localize('en', dict);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
});
