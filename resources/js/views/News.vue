<template>
    <div>
        <br>
        <center>
            Which country do you want to see news for?
            <br><br>
            <button @click="chosen_region('eg')" type="button" class="btn btn-primary" :class="{ 'active' : country_code == 'eg'}">Egypt</button>
            <button @click="chosen_region('ae')" type="button" class="btn btn-primary" :class="{ 'active' : country_code == 'ae'}">UAE</button>
            <br><br>
            <div v-if="country_code">
                Please choose a topic <br><br>
                <button @click="chosen_topic('business')" type="button" class="btn btn-primary" :class="{ 'active' : topic == 'business'}">Business</button>
                <button @click="chosen_topic('sports')" type="button" class="btn btn-primary" :class="{ 'active' : topic == 'sports'}">Sports</button>
            </div>
        </center>
    
        <br><br>
        <div class="container-fluid">
            <div v-for="(article,index) in articles" :key="index">
    
                <div class="row">
                    <center>
                        <div class="col-md-12">
                            <h3>
                                {{article.title}}
    
                            </h3><img :src="article.urlToImage" :width="200" :height="100">
                            <dl>
                                <dt>
        					Snippet from article: <br> 
                            {{article.description}}
        				</dt>
                            </dl>
                        </div>
                    </center>
                </div>
                <div v-if="logged_in">
                    
                    <center>
                        <button v-if="!article.saved" @click="save_headline(article)" type="button" class="btn btn-primary">Save This Headline</button>
                        <button v-else type="button" class="btn btn-success">Saved ❤️</button>
                    </center>
                    
                </div>
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
            country_code: null,
            topic: null,
            logged_in: null
        }
    },
    mounted() {
        if (!this.$session.exists()) {
            this.logged_in = false;
        } else {
            this.logged_in = true;
        }

    },
    methods: {
        load_articles: function() {
            axios.get('/load-news/' + this.country_code + '/' + this.topic)
                .then((response) => {
                    //check existence of data before assigning
                    if (response.data)
                        this.articles = response.data;
                })
                .catch(function(error) {});

        },
        chosen_region: function(chosen_country_code) {
            this.articles = []; //clear previous articles in case user wants to change the region
            this.topic = null; //clear previously selected topic
            if (chosen_country_code == 'eg') {
                this.country_code = 'eg';
            } else {
                this.country_code = 'ae';
            }

        },
        chosen_topic: function(chosen_topic) {
            if (chosen_topic == 'business') {
                //business
                this.topic = 'business';
                this.load_articles();
            } else {
                this.topic = 'sports';
                this.load_articles();
            }
        },
        save_headline: function(article) {
            this.article_preprocess(article) //call our preprocessor
            axios.post("/add-to-favorites", article)
                .then((result) => {
                    console.log("Success")
                    //article.saved = true;
                    this.$set(article, 'saved', true) //this is used instead of a regular assignment (x = y) to trigger vue's reactivity

                })
                .catch((error) => {
                    console.log(error)
                });
        },
        article_preprocess: function (article) { //we need to do some stuff to our article object before we can send
            article.user_id = this.$session.get('user_id') //apend user ID to our object
            if (article.description === null || article.description === '') //edge case where newsAPI does not return a description
            {
                article.description = "No description available"; //we assign a description so that the article does not fail our API's validation
            }
            this.$set(article, 'category', this.topic) //set category so we can have an identifier for the topic in our db
            this.$set(article, 'country', this.country_code) //set country so we can have an identifier for the country in our db
        }
        


    }
}
</script>

<style scoped>
hr {
    overflow: visible;
    /* For IE */
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