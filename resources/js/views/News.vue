<template>
    <div>
        <li v-for="(article,index) in articles" :key="index">
        Source: {{article.source.name}} <br>
        Title: {{article.title}} <br>
        URL: {{article.url}}
        
        </li>
    </div>
</template>


<script>
export default {
    data: function() {
        return {
            articles: [],

        }
    },
    mounted() {

        this.load_articles();
    },

    methods: {
        load_articles: function() {

            axios.get('http://newsapi.org/v2/top-headlines?' +
                    'country=us&' +
                    'apiKey=d68eedc60ffb475abe53a4d5d26acc0c')
                .then((response) => {
                    //check existence of data before assigning
                    if (response.data)
                        this.articles = response.data.articles;
                })
                .catch(function(error) {});
            //console.log("echo")
        },


    }
}
</script>