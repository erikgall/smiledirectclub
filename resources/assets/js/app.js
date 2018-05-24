import "./bootstrap";
import Vue from 'vue'
import App from './App.vue'
import router from './router'

window.Vue = Vue

/**
 * Allow the axios instance to be accessed from with-in components
 * by binding it to the Vue prototype.
 */
Vue.prototype.$http = window.axios

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    extends: App,
}).$mount('#app')
