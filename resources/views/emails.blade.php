<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
    
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>Welcome to the website, {{ $details['user_name'] }}!
    <p>{{ $details['body'] }}<br/>
    <h1>{{ $details['password'] }}<h1></p>
   
    You can login using your new password using the button below:
    <a href="http://localhost:8000/#/login">Login</a>


</body>
</html>