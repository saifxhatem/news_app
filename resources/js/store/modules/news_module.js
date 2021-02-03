import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

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
export default news_module;

