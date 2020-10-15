/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import App from './App.vue';
import Vue from 'vue';
import router from "./router";
import store from "./store";
import {BootstrapVue,IconsPlugin} from 'bootstrap-vue';
require('./bootstrap');

import { ValidationProvider, ValidationObserver, extend, localize} from 'vee-validate';
import * as rules from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";
import VueTimeago from 'vue-timeago';
import VuePluralize from 'vue-pluralize';
import Meta from 'vue-meta';

Vue.use(VuePluralize);
Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en', // Default locale
    // We use `date-fns` under the hood
    // So you can use all locales from it
    // locales: {
    //     'zh-CN': require('date-fns/locale/zh_cn'),
    //     ja: require('date-fns/locale/ja')
    // }
});

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Meta);


// Install VeeValidate rules and localization
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

localize("en", en);

// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




const app = store.dispatch('auth/me').then(()=>{
    new Vue({
        el: '#app',
        router,
        store,
        render: h => h(App),
    });
});



