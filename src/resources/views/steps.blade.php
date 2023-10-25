<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>logged in successfully!</p>
    <p>本日の歩数は{{ $steps }}です！</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>