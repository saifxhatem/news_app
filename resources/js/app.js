require('./bootstrap');

//import packages
window.Vue = require('vue');
import VueRouter from 'vue-router'
import VueSession from 'vue-session'
import VueSpinners from 'vue-spinners'
import Vuex from 'vuex'

//import store

import {store} from './store/store'

//import views
import Login from './views/Login.vue'
import Index from './views/Index.vue'
import Register from './views/Register.vue'
import News from './views/News.vue'
import Logout from './views/Logout.vue'
import Favorites from './views/Favorites.vue'


//use vue-router and vue-session
Vue.use(VueRouter)
Vue.use(VueSession)
Vue.use(VueSpinners)
Vue.use(Vuex)




const routes = [

    { name: 'index', path: '/', component: Index},
    { name: 'register', path: '/register', component: Register},
    { name: 'login', path: '/login', component: Login},
    { name: 'news', path: '/news', component: News},
    { name: 'logout', path: '/logout', component: Logout},
    { name: 'favorites', path: '/favorites', component: Favorites},



]

const router = new VueRouter({
  routes,
  //mode: 'history'
})

//define our components

Vue.component('error-alert', require('./components/ErrorAlert.vue').default);
Vue.component('registration-form', require('./components/RegistrationForm.vue').default);
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('news-loader', require('./components/NewsLoader.vue').default);
Vue.component('favorites-loader', require('./components/FavoritesLoader.vue').default);




const app = new Vue({
  el: '#app',
  store,
  router
}).$mount('#app');