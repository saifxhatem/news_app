<template>
    <div>
        <br>
    
        <div v-if="no_articles"> <!-- If the user has no articles saved, display below message -->
            <center>
                <h2> You have no saved articles. You can save articles from the news page. The button below will take you to the news page. <br></h2>
                <button type="button" @click="$router.push('/news')" class="btn btn-primary">Go To News Page</button>
            </center>
        </div>
        <div v-if="!no_articles"> <!-- If user DOES have saved articles, show the "filter by" selector -->
            <center>
                <h2>Saved Headlines <br> Filter saved articles by:</h2>
            </center>
            <center><select dusk="filter_selector" v-model="sort_by">
                    <option disabled value="">Please select one</option>
                    <option value="business">Business News</option>
                    <option value="sports">Sports News</option>
                    <option value="ae">UAE News</option>
                    <option value="eg">Egypt News</option>
                    <option value="all">All News</option>  
                </select></center>
        </div>
        <br><br>
        <div class="container-fluid">
            <!-- For each article, display specific elements of the article -->
            <div v-for="(article,index) in articles" :key="index">
                <div v-if="sort_by === article.category || sort_by === article.country || sort_by === 'all' "> <!-- Load articles according to filter -->
                    <!-- this selector can be done on the backend, but I decided to use this 
                    as making the selector on the api would result in an API call each time
                    the user changes their selector so frontend seems like the lesser evil for now -->
                    <div v-if="!article.deleted"> <!-- Display articles that have not been deleted by the user -->
                        <button :id="'delete_article_' + index" type="button" @click="unfavorite(article)" class="btn btn-danger" style="float: right;">X</button> <!-- Delete button that calls the unfavorite() method -->
                        <div :id="'article_' + index" class="row">
                        <!-- For each saved headline, display some data about it -->
                            <center>
                                <div class="col-md-12">
                                    <h3>
                                        {{article.title}} -
                                        <h1>{{article.country}} - {{article.category}}</h1>
    
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
            user_id: null, 
            sort_by: null, //used to specify which articles to show based on user's filter pref
            no_articles: null, //flag to signal that the user has no saved articles
        }
    },

    beforeCreate() {
        //check if user is logged in and therefore should have access to this page
        if (!this.$session.exists()) {
            alert("You are not logged in! You will be redirected to homepage");
            this.$router.push('/') //redirect if user is not logged in
        }
    },

    mounted() {
        //get user's id and load their favorited articles
        this.user_id = this.$session.get('user_id')
        this.load_articles();

    },
    methods: {
        load_articles: function() {
            axios.post('load-favorites', { user_id: this.user_id })
                .then((response) => {
                    //check if user has any saved articles
                    if (response.data === undefined || response.data.length == 0) {
                        this.no_articles = true;
                    }
                    if (response.data) //check existence of data before assigning
                        this.articles = response.data;
                })
                .catch(function(error) {});

        },
        unfavorite: function(article) {
            axios.post('delete-favorite', {
                //send the request to delete the article the user wants to remove
                user_id: this.user_id,
                article_id: article.id
                })
                .then((response) => {
                    this.$set(article, 'deleted', true) //this is used instead of a regular assignment (x = y) to trigger vue's reactivity
                })
                .catch(function(error) {});
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