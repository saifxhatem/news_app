import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const user_module = {
    state: {   
        user:
            {
                user_id: null,
                user_name: null,
                status: 0,
                favorite_count: null
            },
    },
    mutations: {
        set_user_favorites_count (state, payload) {
            state.user.favorite_count = payload
        },
        set_user_status (state, payload) {
            if (payload.action === 'logout') {
                //set status state to 0
                state.user.status = 0
            }
            if (payload.action === 'logged_in') {
                //set status state to 1
                state.user.status = 1
            }
        },
    },
    actions: {
        get_user_favorite_count ({commit, state}, query)
        {
            axios.post('get-favorite-count', {
                //send the request to delete the article the user wants to remove
                user_id: query.payload.user_id,
            })
            .then((response) => {
                commit('set_user_favorites_count', response.data)
            })
            .catch(function(error) {});
            
        },
        do_login ({ commit, state, dispatch, rootState }, formData)
        {
            axios.post("login", formData.payload)
                .then((result) => {
                    if (result.status === 205) {
                        state.user.status = 'Invalid login'
                    } else {
                        commit('set_user_status', {action: 'logged_in'})
                        //state.user.status = 1
                        state.user.user_id = result.data.id;
                        state.user.user_name = result.data.name;
                        Vue.prototype.$session.start()
                        Vue.prototype.$session.set('user_id', state.user.user_id)
                        Vue.prototype.$session.set('name', state.user.user_name)
                        alert("You have successfully logged in. You will now be redirected to the homepage.");
                        rootState.router.push({ name: 'index'})
                        
                    }

                })
                .catch((error) => {
                    return error;
                });
        },
        do_logout ({ commit, state }, )
        {
            commit('set_user_status', {action: 'logout'})
        },     
        do_registration ({ commit, state, dispatch }, formData)
        {
            axios.post("register", formData.payload)
                .then((result) => {
                    if (result.status !== 200) {
                        console.log("error")
                    } else {
                        alert("You have been registered on News App. Please check your email for your password.");
                        state.router.push({ name: 'index'})
                        
                    }

                })
                .catch((error) => {
                    return error;
                });
        },
    }
}
const favorites_module = {
    state: {
        favorites: null,
        flags : {
            no_favorites_in_selected_section: null
        }
    },
    actions: {
        load_favorites ({commit, state}, query)
        {
            axios.post('load-favorites', { user_id: query.payload.user_id, filter: query.payload.filter })
                .then((response) => {
                    if (response.status === 216) //no articles
                        commit('set_no_articles_flag', true)
                    if (response.data && response.status != 216) //check existence of data before assigning
                    {                        
                        commit('set_favorites', response.data)
                        commit('set_no_articles_flag', false)
                    }
                        
                })
                .catch(function(error) {});
        },
        save_favorites ({commit, state}, query)
        {
            axios.post('add-to-favorites', query.payload)
                .then((response) => {
                    if (response.status = 200) //check existence of data before assigning
                        console.log("Article saved successfully")
                })
                .catch(function(error) {});
        },
        delete_favorites ({commit, state}, query)
        {
            axios.post('delete-favorite', {
                //send the request to delete the article the user wants to remove
                user_id: query.payload.user_id,
                article_id: query.payload.article_id
            })
            .then((response) => {
                if (response.status = 200) //check existence of data before assigning
                    console.log("Article deleted successfully")
            })
            .catch(function(error) {});
        },
        clear_favorites ({commit, state})
        {
            commit('clear_favorites')
        },
    },
    mutations: {
        set_favorites (state, payload) {
            state.favorites = payload
        },
        clear_favorites (state) {
            state.favorites = []
        },
        set_no_articles_flag (state, payload) {
            if (payload == true)
                state.flags.no_favorites_in_selected_section = true
            if (payload == false)
            state.flags.no_favorites_in_selected_section = false
        }
    }
}
const news_module = {
    state: {
        articles: null,
    },
    actions: {
        load_articles ({commit, state}, url)
        {
            axios.get(url.payload)
                .then((response) => {
                    //check existence of data before assigning
                    if (response.data){
                        //api call successful, assign data
                        commit('set_articles', response.data)
                    }
                })
                .catch(function(error) {});
        },
        clear_articles ({commit, state})
        {
            commit('clear_articles')
        },
    },
    mutations: {
        set_articles (state, payload){
            state.articles = payload
        },
        clear_articles (state) {
            state.articles = []
        },
    }
}
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