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
    },
    
}
export default user_module;

