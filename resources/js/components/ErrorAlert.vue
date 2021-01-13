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


