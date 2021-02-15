<template>
    <div>
        <heading class="mb-6">Favorites Tool</heading>
        <div class="alert" v-if="favorites.length < 1">
            This user has no favorites!
        </div>
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
                <td>{{favorite.id}}</td>
                <td>{{favorite.title}}</td>
                <td>{{favorite.source}}</td>
                <td>{{favorite.description}}</td>
                <td>{{favorite.created_at}}</td>
                <td>
                    <div v-if="favorite.posted_status === 2">
                        <button class="button-posted button4">Posted</button>
                    </div>
                    <div v-else>
                        <button class="button-not-posted button4">Not Posted</button>
                    </div>
                </td>
                <td>
                    <select @change="toggle_posted(favorite, index)" v-model="selected_state[index]" class="form-control form-control-lg">
                            <option v-for="(state, index) in posted_states" :key="index" :value="state.id">{{state.name}}</option>
                        </select>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            selected_state: []
        }
    },
    computed: {
        favorites() {
            return Nova.store.state.favorites
        },
        posted_states() {
            return Nova.store.state.posted_states
        }
    },
    beforeCreate() {
        Nova.store.dispatch({
            type: 'load_favorites',
        })
        Nova.store.dispatch({
            type: 'load_posted_states',
        })
    },
    methods: {
        toggle_posted: function(favorite, index) {
            Nova.store.dispatch('toggle_posted', {
                favorite_id: favorite.id,
                selected_state: this.selected_state[index]
            })
        },
    }
}
</script>

<style>
@import './../css/favorites_table.css';
</style>
