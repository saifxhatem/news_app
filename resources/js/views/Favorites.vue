<template>
    <div>
        <br>
        <center>Your saved headlines:</center>
        <center><select v-model="sort_by">
            <option disabled value="">Please select one</option>
            <option value="business">Business News</option>
            <option value="sports">Sports News</option>
            <option value="ae">UAE News</option>
            <option value="eg">Egypt News</option>
            <option value="all">All News</option>  
        </select></center>
        
        <br><br>
        <div class="container-fluid">
            <div v-for="(article,index) in articles" :key="index">
                <div v-if="sort_by === article.category || sort_by === article.country || sort_by === 'all' "> 
                    <!-- this selector can be done on the backend, but I decided to use this as making the selector on the api would result in more API calls
                    so frontend seems like the lesser evil for now -->
                    <div v-if="!article.deleted">
                        <button type="button" @click="unfavorite(article)" class="btn btn-danger" style="float: right;">X</button>
                        <div class="row">
                            
                                <center>
                                    <div class="col-md-12">
                                        <h3>
                                            {{article.title}} - <h1>{{article.country}} - {{article.category}}</h1>
            
                                        </h3><img :src="article.urlToImage" :width="200" :height="100">
                                        <dl>
                                            <dt>
                                                    Snippet from article: <br> 
                                                    {{article.description}}
                                                    <br>Full article: <br><a :href="article.url"><button class="btn btn-primary">Read on {{article.source}}</button></a>
                                                </dt>
                                        </dl>
                                    </div>
                                </center>
                            
                        </div>
        
        
                        <center>
        
                        </center>
        
        
                        <hr>
                    </div>
                </div>
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
            user_id: null,
            sort_by: null
        }
    },

    beforeCreate() {
        if (!this.$session.exists()) {
            alert("You are not logged in! You will be redirected to homepage");
            this.$router.push('/')
        }
    },

    mounted() {
        this.user_id = this.$session.get('user_id')
        this.load_articles();

    },
    methods: {
        load_articles: function() {
            axios.post('load-favorites', { user_id: this.user_id })
                .then((response) => {
                    //check existence of data before assigning
                    if (response.data)
                        this.articles = response.data;
                    console.log("Success")
                })
                .catch(function(error) {});

        },
        unfavorite: function(article) {
            axios.post('delete-favorite', {
                    user_id: this.user_id,
                    article_id: article.id
                })
                .then((response) => {
                    //check existence of data before assigning
                    console.log("Deleted")
                    this.$set(article, 'deleted', true) //this is used instead of a regular assignment (x = y) to trigger vue's reactivity

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