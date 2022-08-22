<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FRANCKON ENGINEERING</title>
        <link rel="stylesheet" href="/css/all.css">
        
        <script>

             (function(){
                   window.Laravel = {
                    csrfToken:'{{ csrf_token() }}'
                       };
                    })();

        </script>

    </head>
    <body>
        <div id="app">
            @if(auth()->check())
                <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
                <!-- <mainapp :user="{{Auth::user()}}" :permission="null"></mainapp> -->
            @else
                <mainapp :user="false" ></mainapp>
            @endif
        </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
