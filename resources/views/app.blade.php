<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
        {{-- <title>Laravel Vue Inertia</title> --}}

        @vite('resources/js/app.js')
        @vite('resources/css/output.css')
        @inertiaHead
        @routes
    </head>
    <body class="container mx-auto">
        @inertia
    </body>
</html>
