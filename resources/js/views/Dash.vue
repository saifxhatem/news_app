<template>
    
</template>


<script>
export default {
    data() {
        return {

        }
    },

    beforeCreate: function() {
        if (!this.$session.exists()) {
            alert("You are not logged in! You will be redirected to homepage");
            this.$router.push('/')
        }
        else {
            console.log("Kolo tamam")
        }
    }
}
</script>