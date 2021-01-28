import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        
        user:
            {
                user_id: null,
                user_name: null,
                status: 0,

            },
        router: null,
        articles: null
    },
    getters: {
        
        
    },
    mutations: {
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
        set_articles (state, payload){
            //console.log(payload)
            state.articles = payload
        },
        clear_articles (state) {
            state.articles = []
        }
    },
    actions: {
        do_login ({ commit, state, dispatch }, formData)
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
                        state.router.push({ name: 'index'})
                        
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
        get_router ({commit, state}, router)
        {
            state.router = router.payload;
        },
        load_articles ({commit, state}, url)
        {
            //console.log("in load_articles, url = " + url.payload)
            axios.get(url.payload)
                .then((response) => {
                    //check existence of data before assigning
                    if (response.data){
                        //api call successful, assign data
                        //this.loading = false;
                        //this.articles = response.data;
                        commit('set_articles', response.data)
                    }
                })
                .catch(function(error) {});
        },
        clear_articles ({commit, state})
        {
            commit('clear_articles')
        }
    }
    
})