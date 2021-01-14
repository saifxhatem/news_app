<script>
export default {
    mounted(){
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