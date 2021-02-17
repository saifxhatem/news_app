<template>
    <div>
        <heading class="mb-6">Favorites Tool</heading>
        <div class="alert" v-if="favorites.length < 1">
            This user has no favorites!
        </div>
        <div v-else>
            <table id="favorites">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Source</th>
                    <th>Description</th>
                    <th>Date of Creation</th>
                    <th>Posted Status</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="(favorite, index) in favorites" :key="index">
                    <td>
                        {{favorite.id ? favorite.id : 'Missing ID'}}
                    </td>
                    <td>
                        {{favorite.title ? favorite.title : 'Missing Title'}}
                    </td>
                    <td>
                        {{favorite.source ? favorite.source : 'Missing Source'}}
                    </td>
                    <td>
                        {{favorite.description ? favorite.description : 'Missing Description'}}
                    </td>
                    <td>
                        {{favorite.created_at ? favorite.created_at : 'Missing Creation Date'}}
                    </td>
                    <td>
                        <div v-if="favorite.favorite_status_string === 'posted'">
                            <button class="button-posted button4">Posted</button>
                        </div>
                        <div v-else>
                            <button class="button-not-posted button4">Not Posted</button>
                        </div>
                    </td>
                    <td>
                        <select @change="toggle_posted(favorite, index)" v-model="selected_state[index]" class="form-control form-control-lg">
                                <option v-for="(state, index) in posted_states" :key="index" :value="state.id">
                                    {{state.name ? state.name : 'Bad State'}}
                                </option>
                            </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            selected_state: [],
        }
    },
    computed: {
        favorites() {
            return Nova.store.state.favorites.favorites
        },
        posted_states() {
            return Nova.store.state.favorites.posted_states
        }
    },
    mounted() {
        Nova.store.dispatch({
            type: 'get_current_user_id',
        }).then(response => {
            console.log("user_id set, dispatching favorites")
            Nova.store.dispatch({
                type: 'load_favorites',
            })
        })
        Nova.store.dispatch({
            type: 'load_posted_states',
        })
    },
    methods: {
        toggle_posted: function(favorite, index) {
            let selectedState = this.selected_state[index]
            if (selectedState !== null && selectedState !== undefined) {
                Nova.store.dispatch('toggle_posted', {
                    favorite_id: favorite.id,
                    selected_state: this.selected_state[index]
                })
            }
        },

    }
}
</script>

<style>
@import './../css/favorites_table.css';
</style>
