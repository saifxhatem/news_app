import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

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

export default favorites_module;
