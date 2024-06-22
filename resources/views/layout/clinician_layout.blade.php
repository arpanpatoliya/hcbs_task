<!DOCTYPE html>
<html lang="en">

<head>
    <title>HCBS </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')

    @include('include.style')
</head>

<body>
    <input type="hidden" id="base_url" value="{{ url('/') }}">
    @include('include.loader')

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('include.header')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('include.sidebar')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('include.script')
    @include('notify')
    @if (Session::has('message'))
    <script>
        var message = '{{ Session::get('message') }}';
        notify(message);
    </script>
    @endif
    @yield('js')
    
</body>

</html>
