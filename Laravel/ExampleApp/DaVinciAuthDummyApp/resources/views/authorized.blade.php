<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dummy Authorized</title>
</head>
<body>
   <h2>You are authorized {{ $user->userNumber }}</h2>
   <h4>Your privilege level is {{ $user->authLevel }}</h4> 
</body>
</html>