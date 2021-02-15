<template>
    <div>
        <heading class="mb-6">Favorites Tool</heading>
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
/* Scoped Styles */

#favorites {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#favorites td,
#favorites th {
    border: 1px solid #ddd;
    padding: 8px;
}

#favorites tr:hover {
    background-color: #ddd;
}

#favorites th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

.button-posted {
    background-color: #4CAF50;
    /* Green */
    border: none;
    color: white;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button-not-posted {
    background-color: #dd101a;
    /* Red */
    border: none;
    color: white;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button4 {
    border-radius: 12px;
}
</style>
