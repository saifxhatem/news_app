<!DOCTYPE html>
<html>
<head>
    
    
</head>
<body>
    <!-- Define the structure of the email here -->
    <h3>{{ $details['title'] }}</h3>
    <p>Welcome to the website, {{ $details['user_name'] }}!
    <p>{{ $details['body'] }}<br/>
    <h1>{{ $details['password'] }}<h1></p>
   
    <p>You can login using your new password by clicking link below: <br>
    <a href="http://localhost:8000/#/login">Login</a></p>


</body>
</html>