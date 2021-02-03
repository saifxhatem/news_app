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
            greet_message: "Welcome to News App, Guest!" //default greet message
        }
    }
    ,
    mounted(){
        this.session_check();
    },

    methods: {
        //check to see if user is logged in or not and set greet message if user is logged in
        session_check: function() {
            if (this.$session.exists()) {
                this.greet_message = "Welcome to News App, " + this.$session.get('name') + "!"
            }
        }
    }
    
}
</script>