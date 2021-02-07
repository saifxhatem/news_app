<template>
    <div>
        <heading class="mb-6">Username Tool</heading>
    
        <card class="bg-90 flex flex-col items-center justify-center" style="min-height: 300px">
        </card>
        <div v-if="user_object">    
            <center> 
                ID: {{user_object.id}} <br>
                Name: {{user_object.name}} <br>
                Email: {{user_object.email}} <br>
            </center>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            user_object: [],
        }
    },

    mounted() {
        //
        this.get_user_object();

    },

    methods: {
        get_user_object: function() {
            Nova.request().get('/nova-vendor/username-tool/get_current_user')
                .then((response) => {
                    // handle success
                    if (response.data)
                    {
                        this.user_object = response.data
                        
                    }

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
