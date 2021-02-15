<template>
    <favorites-table></favorites-table>
</template>

<script>

import FavoritesTable from './FavoritesTable'

export default {
    components: {
        FavoritesTable
    },
    beforeCreate() {
        Nova.store.dispatch({
          type: 'get_current_user_id',
        })
    },
}

</script>

