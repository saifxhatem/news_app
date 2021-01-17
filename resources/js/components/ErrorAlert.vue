<!-- This is a simple component that displays a bootstrap error alert
   and it takes two props, "message" e.g "Registration Failed" and "error" which is the specific error encountered
   e.g. "Email is already in use"
-->
<template>
    <div class="alert alert-danger" role="alert">
        <center>
            {{message}}<br/> {{error}}
        </center>
    </div>
</template>


<script>
export default {

    props: {

        message: {
            type: String,
            default: "My Message"
        },
        error: {
            type: String,
            default: ""
        }

    },
}
</script>


