<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <title>{{env('APP_NAME')}}</title>


</head>
<body>

    <div id= "app">
    <center>
        <router-link to="/">Home</router-link>
        <div v-if="$session.exists()"> <!--  If user is logged in -->
            <router-link to="/dash">Dash</router-link>
            <router-link to="/logout">Logout</router-link>
            <router-link to="/news">News</router-link>
        </div>
        <div v-if="!$session.exists()"> <!--  If user is not logged in -->
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        </div>
        
    </center>
    <router-view/> 
    
    </div>
    

    <script src="{{ mix('js/app.js') }}"></script>
    
</body>
</html>
