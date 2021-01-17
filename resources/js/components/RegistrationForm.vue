<!-- This is the registration component, it has a form where users input their details 
     and attempt to register on our app.
-->

<template>
    <div>
        <br/><br/>
        <error-alert v-if="show_error" message="Registration Failed" :error="err_msg"> </error-alert> <!-- If error flag is set, show error alert component -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>
    
                        <div class="card-body">
                            <form @submit.prevent="validate_form" method="post"> <!-- When user clicks Register button, call validate_form() method -->
                                <div class="form-group">
                                    <label for="user-name-label">Full Name </label>
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_name_failed}" id="user-name" placeholder="Ex: John Smith" v-model="formData.user_name" />
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="new-address-label">Email</label>
                                    <input type="email" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_email_failed}" id="email" placeholder="Ex: 19 Hosny El Ashmawy" v-model="formData.user_email" />
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="new-address-label">Date of Birth</label>
                                    <input type="date" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_dob_failed}" v-model="formData.user_dob">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Register</button>
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
                user_name: null,
                user_email: null,
                user_dob: null
                //This is the data from our forms
            },
            validation_errors: {
                user_name_failed: null,
                user_email_failed: null,
                user_dob_failed: null
                //flags to signal that validation errors have occured
            },
            show_error: false, //flag to show the error alert component
            err_msg: "", //error message to display in the error alert component
            date_today_string: null 
            /*this string holds a date in "YYYY-MM-DD" format, 
            and is used to in validating a user's date of birth. */

        }


    },



    methods: {
        postData(e) {
            //all inputs validated, make the call to post the data
            axios.post("register", this.formData)
                .then((result) => {
                    alert("You have been registered on News App. Please check your email for your password.");
                    this.$router.push({ name: 'index'})

                })
                .catch((error) => {
                    this.show_error = true;
                    let errors = error.response.data.errors;
                    for (error in errors) {
                        if (error = "user_email") this.err_msg = "Email is already in use."
                    }
                });


        },

        validate_form() {
            
            this.clear_validation_flags(); //clear flags from previous runs
            this.date_setter(); //get today's date
            
            /*
                Each if condition checks if a certain field is empty and sets the 
                corresponding validation error flag.
                If there are no validation error flags set the last if condition calls the postData() method
                which does the post request to our backend.
            */

            if (this.formData.user_email === null || this.formData.user_email === '') { //check if email is not set
                this.show_error = true;
                this.err_msg += "Email cannot be empty."
                this.validation_errors.user_email_failed = true;
            }
            if (this.formData.user_name === null || this.formData.user_name === '') { //check if user's name is not set
                this.show_error = true;
                this.err_msg += " Name cannot be empty."
                this.validation_errors.user_name_failed = true;
            }
            if (this.formData.user_dob === null || this.formData.user_dob === '') { //check if user's date of birth is not sett
                this.show_error = true;
                this.err_msg += " Date of birth cannot be empty."
                this.validation_errors.user_dob_failed = true;
            }
            if (this.formData.user_dob > this.date_today_string) { //check if user's date is incorrect (after today)
                this.show_error = true;
                this.err_msg += " Date of birth is incorrect."
                this.validation_errors.user_dob_failed = true;
            }
            if (!this.validation_errors.user_email_failed && !this.validation_errors.user_name_failed && !this.validation_errors.user_dob_failed) { //if everything is in order, post
                this.show_error = false;
                this.err_msg = "";
                this.postData()
            }
        },
        clear_validation_flags() { 
            /*
                Clear validation flags from previous validation
            */
            this.err_msg = "";
            this.validation_errors.user_email_failed = null;
            this.validation_errors.user_name_failed = null;
            this.validation_errors.user_dob_failed = null;
        },
        date_setter() { 
            //get today's date 
            let today = new Date();
            //transform the date to be in YYYY-MM-DD format (same format as MYSQL date column type
            today = today.getUTCFullYear() + '-' +
                ('00' + (today.getUTCMonth() + 1)).slice(-2) + '-' +
                ('00' + today.getUTCDate()).slice(-2) + ' '
            //finally assign the value to our string    
            this.date_today_string = today;
        }
    }
}
</script>
