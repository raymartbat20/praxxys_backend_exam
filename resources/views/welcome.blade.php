<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- In the head of your document with your other CSS includes... -->
        <!-- Video.js base CSS -->
        <link
        href="https://unpkg.com/video.js@7/dist/video-js.min.css"
        rel="stylesheet"
        />
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
    </body>
    <script src="{{mix('js/app.js')}}"></script>
</html>
