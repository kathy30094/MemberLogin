<!doctype html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- 加入X-CSRF-TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div id="app">
                    <agent-page></agent-page>
                </div>
            </div>
        </div>
        <script src="/js/app.js">
        </script>
    </body>
</html>
