<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to the Blog Management {{$user['name']}}</h2>
    <br/>
    Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
    <br/>
    <a class="btn btn-primary" href="{{url('user/verify', $user['id'])}}">Verify Email</a>
  </body>
</html>