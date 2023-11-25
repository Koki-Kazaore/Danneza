<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRFトークンの挿入を追加 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel App</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
