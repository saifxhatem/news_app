require('./bootstrap');


window.Vue = require('vue');
import VueRouter from 'vue-router'

//import views
import Login from './views/Login.vue'
import Index from './views/Index.vue'
//import Register from './views/Register.vue'
import News from './views/News.vue'



Vue.use(VueRouter)



const routes = [

    { name: 'index', path: '/', component: Index},
//    { name: 'register', path: '/register', component: Register},
    { name: 'login', path: '/login', component: Login},
    { name: 'news', path: '/news', component: News},
    

  
]

const router = new VueRouter({
  routes,
  //mode: 'history'
})



const app = new Vue({
  el: '#app',
  router
}).$mount('#app');
