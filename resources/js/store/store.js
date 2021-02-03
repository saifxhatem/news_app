import Vue from 'vue';
import Vuex from 'vuex';
import user_module from './modules/user_module';
import favorites_module from './modules/favorites_module';
import news_module from './modules/news_module';


Vue.use(Vuex);




export const store = new Vuex.Store({
    modules: {
        user: user_module,
        favorites: favorites_module,
        news: news_module
    },
    state: {
        router: null
    },
    actions: {
        get_router ({commit, state}, router)
        {
            commit('set_router', router.payload)
        },
    },
    mutations: {
        set_router (state, payload)
        {
            state.router = payload;
        }
    }
    
    
})