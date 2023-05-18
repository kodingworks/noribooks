<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', '') }}</title>
    <!-- Scripts -->
    @routes
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @inertiaHead
    
</head>

<body class="bg-gray-100 font-sans antialiased">
    @inertia
</body>

</html>