<template>
    <div>
        <br>
        <center>
        Which country do you want to see news for?
        <br><br>
        <button @click="chosen_region('eg')" type="button" class="btn btn-primary">Egypt</button>
        <button @click="chosen_region('ae')" type="button" class="btn btn-primary">UAE</button>
        </center>

        <br><br>
        <div class="container-fluid">
            <div v-for="(article,index) in articles" :key="index">
    
                <div class="row"><center>
                    <div class="col-md-12">
                        <h3>
                            {{article.title}}
    
                        </h3><img :src="article.urlToImage" :width="200" :height="100">
                        <dl>
                            <dt>
    					Snippet from article: {{article.description}}
    				</dt>
                        </dl>
                    </div>
                </center></div>
                <hr>
    
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data: function() {
        return {
            articles: [],
            country_code: null

        }
    },
    mounted() {

        //this.load_articles();
    },

    methods: {
        load_articles: function() {

            // axios.get('http://newsapi.org/v2/top-headlines?' +
            //         'country=us&' +
            //         'apiKey=d68eedc60ffb475abe53a4d5d26acc0c')
            //     .then((response) => {
            //         //check existence of data before assigning
            //         if (response.data)
            //             this.articles = response.data.articles;
            //     })
            //     .catch(function(error) {});
            
            axios.get('/load-news/' + this.country_code)
                .then((response) => {
                    //check existence of data before assigning
                    console.log(response.data)
                    if (response.data)
                        this.articles = response.data;
                })
                .catch(function(error) {});
            
        },
        chosen_region: function(chosen_country_code)
        {
            console.log("Chosen region: " + chosen_country_code)
            this.country_code = chosen_country_code;
            this.load_articles();
        }


    }
}
</script>

<style scoped>
hr {
    overflow: visible; /* For IE */
    padding: 0;
    border: none;
    border-top: medium double #333;
    color: #333;
    text-align: center;
}
hr:after {
    content: "§";
    display: inline-block;
    position: relative;
    top: -0.7em;
    font-size: 1.5em;
    padding: 0 0.25em;
    background: white;
}
</style>