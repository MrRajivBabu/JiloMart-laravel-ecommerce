<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body>
    <p>Hello, {{ $formData['user']->name }}</p>
    <h2>{{ $formData['subject'] }}</h2>
    <p>Please click the link to reset Password</p>
    <a href="{{ route('resetPassword',$formData['token']) }}" target="_blank"> Click Here </a>
    <p>Thanks</p>
</body>
</html>

