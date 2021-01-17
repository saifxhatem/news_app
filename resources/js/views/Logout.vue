<template>
    
</template>

<script>
export default {
    mounted(){
        //check if user is logged in, and if they are logged in log them out and destroy the session.
        if (!this.$session.exists()) {
            alert("You are not logged in! You will be redirected to the homepage");
            this.$router.push('/')
        }
        else {
            this.$session.destroy();
            alert("You have been logged out. You will now be redirected to the homepage");
            this.$router.push('/')
        }
    }
}
</script>