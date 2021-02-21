import Vuex from 'vuex';
import favorites_table_module from './store_modules/favorites_table_module';



Nova.booting((Vue, router, store) => {
  Vue.use(Vuex);
  Nova.store = new Vuex.Store({
    modules: {
      favorites: favorites_table_module
    },
  })

  router.addRoutes([
    {
      name: 'favorites-tool',
      path: '/favorites-tool',
      component: require('./components/Tool'),
    },
  ])
})
