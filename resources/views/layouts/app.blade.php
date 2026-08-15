<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'News Management')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @stack('head')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
