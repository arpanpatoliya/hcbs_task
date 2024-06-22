<!DOCTYPE html>
<html lang="en">


<head>
    <title>HCBS | Login</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <link rel="icon" href="{{ asset('logos') }}/android-chrome-192x192.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/snackbar/snackbar.min.css" media="screen" title="no title" charset="utf-8">

    <style>
        .error-help-block{
            color: red;
        }
    </style>
</head>

<body class="fix-menu">

    <div class="theme-loader">
        <div class="ball-scale">
            <div class="contain">
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>

    <section class="login-block">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('clinician-checkauth') }}" method="post" class="md-float-material form-material" id="form-login">
                        @csrf
                        <div class="text-center">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Sign In</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control"
                                        placeholder="Your Email Address">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign
                                            in</button>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script type="text/javascript" src="{{ asset('assets') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/assets/js/common-pages.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{ asset('assets') }}/snackbar/snackbar.min.js" charset="utf-8"></script>

    {!! JsValidator::formRequest('App\Http\Requests\ClinicianLoginRequest', '#form-login') !!}
    @include('notify')
    @if (Session::has('message'))
    <script>
        var message = '{{ Session::get('message') }}';
        notify(message);
    </script>
    @endif
</body>

</html>
