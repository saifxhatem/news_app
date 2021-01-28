<template>
    <div>
        <br>
        <center>
            Which country do you want to see news for?
            <br><br>
            <!-- The two buttons below call the chosen_region() method to set the country the user wants to see news from -->
            <button dusk="choose_egypt" @click="chosen_region('eg')" type="button" class="btn btn-primary" :class="{ 'active' : country_code == 'eg'}">Egypt</button>
            <button dusk="choose_ae" @click="chosen_region('ae')" type="button" class="btn btn-primary" :class="{ 'active' : country_code == 'ae'}">UAE</button>
            <br><br>
            <div v-if="country_code">
                <!-- The two buttons below call the chosen_topic() method to set the topic the user wants to see news from -->
                Please choose a topic <br><br>
                <button dusk="choose_business" @click="chosen_topic('business')" type="button" class="btn btn-primary" :class="{ 'active' : topic == 'business'}">Business</button>
                <button dusk="choose_sports" @click="chosen_topic('sports')" type="button" class="btn btn-primary" :class="{ 'active' : topic == 'sports'}">Sports</button>
            </div>
        </center>

        <br><br>
        <div id="loading_spinner" v-if="loading">
            <fold></fold>
        </div>
        <div v-else>
            <div class="container-fluid">
                <div dusk="articles" v-for="(article,index) in articles" :key="index">
                    <!-- display each article -->
                    <div class="row">
                        <center>
                            <div class="col-md-12">
                                <h3>
                                    {{article.title}}
        
                                </h3>
                                <!-- Since some articles do not have a given picture, in the case that they don't we assign one for aesthetic purposes -->
                                <div v-if="article.urlToImage">
                                    <img :src="article.urlToImage" :width="200" :height="100">
                                </div>
                                <div v-else>
                                    <img src="https://cdn3.iconfinder.com/data/icons/ballicons-reloaded-free/512/icon-70-512.png" :width="200" :height="100">
                                </div>    
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
                            <!-- If article has not been saved, display option to save
                                Else, make the button display "saved" -->
                            <button dusk="save_headline_button" :id="'save_headline_' + index" v-if="!article.saved" @click="save_headline(article)" type="button" class="btn btn-primary">Save This Headline</button>
                            <button dusk="saved_headline_button" :id="'saved_headline_' + index"  v-else type="button" class="btn btn-success">Saved ❤️</button>
                        </center>
                        
                    </div>
                    <br>
                    <center>Full article: <br><a :href="article.url"><button class="btn btn-info">Read on {{article.source.name}}</button></a></center>
                    <hr>
        
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data: function() {
        return {
            //articles: [],
            country_code: null,
            topic: null,
            logged_in: null,
            loading: false
        }
    },
    computed: {
        articles () {
            
            return this.$store.state.articles;
            
        }
    },
    mounted() {
        //check if our user is logged in so we can show the button to save articles
        if (!this.$session.exists()) {
            this.logged_in = false;
        } else {
            this.logged_in = true;
        }

    },
    methods: {
        load_articles: function() {
            this.loading = true;
            console.log(this.loading)
            let url = '/load-news/' + this.country_code + '/' + this.topic;
            this.$store.dispatch({
                    type: 'load_articles',
                    payload: url
                })
            console.log(this.loading)
            this.loading = false;
            
            console.log(this.loading)

        },
        chosen_region: function(chosen_country_code) {
            //this.articles = []; //clear previous articles in case user wants to change the region
            this.$store.dispatch({
                    type: 'clear_articles',
                })
            this.topic = null; //clear previously selected topic
            if (chosen_country_code === 'eg') {
                //assign user's chosen country
                this.country_code = 'eg';
            } else {
                this.country_code = 'ae';
            }

        },
        chosen_topic: function(chosen_topic) {
            if (chosen_topic === 'business') {
                //assign user's chosen topic
                this.topic = 'business';
                this.load_articles();
            } else {
                this.topic = 'sports';
                this.load_articles();
            }
        },
        save_headline: function(article) {
            this.article_preprocess(article) //call our preprocessor
            console.log("Before dispatch: article = ")
            console.log(article)
            this.$store.dispatch({
                    type: 'save_favorites',
                    payload: article
                })
            this.$set(article, 'saved', true) //this is used instead of a regular assignment (x = y) to trigger vue's reactivity
        },
        article_preprocess: function (article) { //we need to do some stuff to our article object before we can send it to our backend and save it
            article.user_id = this.$session.get('user_id') //apend user ID to our object
            if (article.description === null || article.description === '') //edge case where newsAPI does not return a description
            {
                article.description = "No description available"; //we assign a description so that the article does not fail our API's validation
            }
            if (article.urlToImage === null || article.urlToImage === '') //sometimes NewsAPI does not return an article image
            {
                article.urlToImage = "https://cdn3.iconfinder.com/data/icons/ballicons-reloaded-free/512/icon-70-512.png"; //we assign a urlToImage so that the article does not fail our API's validation
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