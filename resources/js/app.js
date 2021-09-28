import Vue from "vue";
window.Vue = require('vue');
require('./bootstrap');
require('./table');
import storeVuex from './store/index'
// import filter from './filter'
import moment from 'moment'

Vue.prototype.moment = moment
import Vuex from 'vuex'


import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

const store = new Vuex.Store(storeVuex)

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    store
});
