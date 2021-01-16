<template>
    <div>
        <br/>
        <error-alert v-if="show_error" :message="err_msg"> </error-alert>
        <div v-if="errors">
    
            <div v-for="(error,index) in errors" :key="index">
                <error-alert :message="error[0]"> </error-alert>
            </div>
    
        </div>
    
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
    
                        <div class="card-body">
                            <form @submit.prevent="validate_form" method="post">
                                <div class="form-group">
                                    <label for="user-email-label">Email </label>
                                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_email_failed}" id="email" placeholder="Ex: johnsmith@gmail.com" v-model="formData.user_email" />
    
                                </div>
    
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" v-bind:class="{ 'is-invalid' : validation_errors.user_password_failed}" id="password" v-model="formData.user_password" />
                                </div>
    
                                <button type="submit" class="btn btn-primary">Login</button>
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
            },
            validation_errors: {
                user_password_failed: null,
                user_email_failed: null,
            },
            show_error: false,
            err_msg: "",
            errors: null,
            user_id: null
        }
    },



    methods: {
        postData(e) {
            
            axios.post("login", this.formData)
                .then((result) => {
                    if (result.status === 205) {
                        this.show_error = true;
                        this.err_msg = "Email or password are incorrect."
                    } else {
                        this.show_error = false;
                        this.errors = "";
                        this.$session.start()
                        this.$session.set('user_id', result.data.id)
                        this.$session.set('name', result.data.name)
                        console.log("session id: " + this.$session.id())
                        console.log("session -> user_id: " + this.$session.get('user_id'))
                        alert("You have successfully logged in. You will now be redirected to the homepage.");
                        this.$router.push({ name: 'index'})
                    }

                })
                .catch((error) => {
                    this.errors = error.response.data.errors;

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
            if (this.formData.user_password === null || this.formData.user_password === '') {
                this.show_error = true;
                this.err_msg += " Password cannot be empty."
                this.validation_errors.user_password_failed = true;
            }
            if (!this.validation_errors.user_email_failed && !this.validation_errors.user_password_failed)
            {
                this.show_error = false;
                this.err_msg = "";
                this.postData()
            }
        },
        clear_validation_flags() {
            this.err_msg = "";
            this.validation_errors.user_email_failed = null;
            this.validation_errors.user_password_failed = null;
        }
    }
}
</script>
