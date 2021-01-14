<template>
    <div>
    <h1>Dashboard </h1>
    <center><h2> User ID:{{ $session.get('user_id') }} </h2></center>
    </div>
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