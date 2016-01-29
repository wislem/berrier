<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta property="description" content="{{ $meta['desc'] }}">
        <title>{{ $meta['title'] }}</title>

        @yield('css')
    </head>
    <body>

        @yield('content')

        @yield('js')
    </body>
</html>