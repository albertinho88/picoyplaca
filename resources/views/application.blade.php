<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" />

        <title>Pico y Placa - Predictor</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>

        <div id="picoplaca"></div>

        <script src="{{ asset('js/app.js') }}"></script>

    </body>

</html>
