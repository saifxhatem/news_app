<template>
    <div>
        <br/><br/>
        <h2><center>{{greet_message}}</center></h2>
    </div>

</template>


<script>
export default {
    data() {
        return {
            greet_message: "Welcome to News App, Guest!"
        }
    }
    ,
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
                this.greet_message = "Welcome to News App, " + this.$session.get('name') + "!"
            }
        }
    }
    
}
</script>