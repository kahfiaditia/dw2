require('./bootstrap');

window.Vue = require('vue').default;

import { Form, HasError, AlertError, AlertSuccess } from 'vform';
window.Form = Form
// Vue.component(HasError.name, HasError)
// Vue.component(AlertError.name, AlertError)

let Fire = new Vue()
window.Fire = Fire

import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})
window.Toast = Toast

import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// load awal di laravel
Vue.component('header-component', require('./components/Header.vue').default);
Vue.component('contact-component', require('./components/Contact.vue').default);

// content dinamis
const Profile = require('./components/Profile.vue').default;
const Chat = require('./components/Chat.vue').default;
const routes = [
    {
        path: '/contact/:id?', name: 'contact', component: Profile, props: true
    },
    {
        path: '/converstation/:id?', name: 'converstation', component: Chat, props: true
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
});

