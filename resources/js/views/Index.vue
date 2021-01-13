<template>
    <div>
        <br/><br/>
        <h2>Hello World!</h2>
        <br> <br>
        <center></center>
    </div>

</template>


<script>
export default {
    
    mounted(){
        this.session_check();
    },

    methods: {
        session_check: function() {
            if (!this.$session.exists()) {
                console.log("User not logged")
            }
            else {
                console.log("User logged in! ID = " + this.$session.get('user_id'))
            }
        }
    }
    
}
</script>