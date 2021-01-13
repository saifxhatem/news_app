<template>
    <div>
        <br/><br/>
        <error-alert v-if="show_error" message="Registration Failed" :error="err_msg"> </error-alert>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>
    
                        <div class="card-body">
                            <form @submit.prevent="validate_form" method="post">
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
            },
            validation_errors: {
                user_name_failed: null,
                user_email_failed: null,
                user_dob_failed: null
            },
            show_error: false,
            err_msg: "",
            
        }


    },



    methods: {
        postData(e) {
            
            axios.post("register", this.formData)
                .then((result) => {
                    console.log("Success")
                    //this.$router.push({ name: 'home', params: { user_id: this.user_id } })

                })
                .catch((error) => {
                    this.show_error = true;
                    console.log(this.validation_errors)
                    console.log(this.formData)
                    if (error.response.status == 422) {

                        this.err_msg = "Shit happened"
                    }
                });


        },
        
        validate_form() {
            //clear flags from previous runs
            this.clear_validation_flags();
            
            if (this.formData.user_email === null || this.formData.user_email === '') {
                this.show_error = true;
                this.err_msg += "Email cannot be empty."
                this.validation_errors.user_email_failed = true;
            }
            if (this.formData.user_name === null || this.formData.user_name === '') {
                this.show_error = true;
                this.err_msg += " Name cannot be empty."
                this.validation_errors.user_name_failed = true;
            }
            if (this.formData.user_dob === null || this.formData.user_dob === '') {
                this.show_error = true;
                this.err_msg += " Date of birth cannot be empty."
                this.validation_errors.user_dob_failed = true;
            }
            if (!this.validation_errors.user_email_failed && !this.validation_errors.user_name_failed && !this.validation_errors.user_dob_failed) {
                this.show_error = false;
                this.err_msg = "";
                this.postData()
            }
        },
        clear_validation_flags() {
            this.err_msg = "";
            this.validation_errors.user_email_failed = null;
            this.validation_errors.user_name_failed = null;
            this.validation_errors.user_dob_failed = null;
        },
    }
}
</script>
