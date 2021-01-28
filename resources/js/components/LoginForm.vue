<!-- This is the login component, it has a form where users input their credentials and it attempts to log them in.
     It also validates the form to make sure none of the forms are empty.
-->

<template>
    <div>
        <div>
        
        </div>
        <br/>
        <error-alert v-if="show_error" message="Login failed." :error="err_msg"> </error-alert> <!-- If error flag is set, show error alert component -->
        <div v-if="errors">
            <div v-for="(error,index) in errors" :key="index"> <!-- Display errors here -->
                <error-alert :message="error[0]"> </error-alert>
            </div>
        </div>
    
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
    
                        <div class="card-body">
                            <form @submit.prevent="validate_form" method="post"> <!-- When user clicks Login button, call validate_form() method -->
                                <div class="form-group">
                                    <label for="user-email-label">Email </label>
                                    <input dusk="user_email" type="text" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_email_failed}" id="email" placeholder="Ex: johnsmith@gmail.com" v-model="formData.user_email" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input dusk="user_password" type="password" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_password_failed}" id="password" v-model="formData.user_password" />
                                </div>
    
                                <button dusk="do_login" type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {



    data() {
        return {
            formData: {
                user_password: null,
                user_email: null
                //This is the data from our forms
            },
            validation_errors: {
                user_password_failed: null,
                user_email_failed: null,
                //flags to signal that validation errors have occured
            },
            show_error: false, //flag to show the error alert component
            err_msg: "", //error message to display in the error alert component
            errors: null, //error array that is returned from laravel 
        }
    },


    computed: {
        
    },
    mounted() {
        this.$store.dispatch({
                    type: 'get_router',
                    payload: this.$router
                })
    },
    methods: {
        validate_form() {
            //clear flags from previous runs
            this.clear_validation_flags();

            /*
                Each if condition checks if a certain field is empty and sets the 
                corresponding validation error flag.
                If there are no validation error flags set the last if condition calls the postData() method
                which does the post request to our backend.
            */
            if (this.formData.user_email === null || this.formData.user_email === '') {
                this.show_error = true;
                this.err_msg += "Email cannot be empty."
                this.validation_errors.user_email_failed = true;
            }
            if (this.formData.user_password === null || this.formData.user_password === '') {
                this.show_error = true;
                this.err_msg += " Password cannot be empty."
                this.validation_errors.user_password_failed = true;
            }
            if (!this.validation_errors.user_email_failed && !this.validation_errors.user_password_failed)
            {
                this.show_error = false;
                this.err_msg = "";
                //this.postData()
                this.$store.dispatch({
                    type: 'do_login',
                    payload: this.formData
                })
            }
        },
        clear_validation_flags() {
            /*
                Clear validation flags from previous validation
            */
            this.err_msg = "";
            this.validation_errors.user_email_failed = null;
            this.validation_errors.user_password_failed = null;
        }
    }
}
</script>
