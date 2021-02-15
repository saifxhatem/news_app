import Vuex from 'vuex';
import NovaApiParser from './components/helpers/nova_api_parser'
const Parser = new NovaApiParser

Nova.booting((Vue, router, store) => {
  Vue.use(Vuex);
  Nova.store = new Vuex.Store({
    state: {
      favorites: null,
      user_id: null,
      posted_states: []

    },
    mutations: {
      set_favorites(state, payload) {
        state.favorites = payload
      },
      set_user_id(state, payload) {
        state.user_id = payload
      },
      set_posted_states(state, payload) {
        state.posted_states = payload
      },
      
    },
    actions: {
      get_current_user_id ({commit, state, dispatch})
      {
        Nova.request().get('/nova-vendor/favorites-tool/get_current_user_id')
        .then((response) => {
            // handle success
            if (response.data) {
              commit('set_user_id', response.data)
              dispatch('load_favorites')
            }

        })
        .catch(function(error) {
            // handle error
            console.log(error);
        })
      },
      load_favorites ({commit, getters})
      {
        let base_url = "/nova-api/favorites?search=&filters="
        let filters = []
        filters.push({
          class: "App\\Nova\\Filters\\UserIDFilter",
          value: getters.get_user_id
        })
        filters.push({
          class: "App\\Nova\\Filters\\BeforeDateFilter",
          value: ""
        })
        filters.push({
          class: "App\\Nova\\Filters\\AfterDateFilter",
          value: ""
        })
        let encoded_filters = btoa(JSON.stringify(filters))
        let final_url = base_url + encoded_filters
        Nova.request().get(final_url)
        .then((response) => {
            // handle success
            let parsed_array = Parser.parse(response)
            commit('set_favorites', parsed_array)
            


        })
      },
      toggle_posted ({commit, state, dispatch}, payload)
      {
        Nova.request().post('/toggle-posted', {
          favorite_id: payload.favorite_id,
          selected_state: payload.selected_state
        })
        .then((response) => {
          // handle success
          if(response.status === 200) {
            Nova.store.dispatch({
                type: 'load_favorites',
              })
              //this.selected_state = null
          }
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
      },
      load_posted_states ({commit, state})
      {
        Nova.request().get('/get-posted-states')
          .then((response) => {
              // handle success
              if (response.data) {
                commit('set_posted_states', response.data)
              }
          })
          .catch(function(error) {
              // handle error
              console.log(error);
          })
      }
    },
    getters: {
      get_user_id: state => {
        return state.user_id
      }
    }
  })

  router.addRoutes([
    {
      name: 'favorites-tool',
      path: '/favorites-tool',
      component: require('./components/Tool'),
    },
  ])
})
