<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AFH Admin</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{ url('/animals') }}">Animals</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    AFH
                </div>

                <div class="links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Dashboard</a>
                        <a href="{{ url('/animals') }}">Manage Animal Inventory</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
