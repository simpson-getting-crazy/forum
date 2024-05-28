<!doctype html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Responsive HTML5 Template">
    <meta name="author" content="author.com">
    <title>Responsive HTML5 Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('bootstrap-forum/fonts/icons/main/mainfont/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/fonts/icons/font-awesome/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('bootstrap-forum/vendor/bootstrap/v3/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/vendor/bootstrap/v4/bootstrap-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/css/style.css') }}">
</head>

<body>

    <div class="signup">
        <!-- HEADER -->
        <header class="signup__header">
            <div class="container">
                <div class="signup__header-content">
                    <p><a href="#">Do not have an account?</a></p>
                    <a href="/register" class="btn-base">Sign Up</a>
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main class="signup__main">
            <img class="signup__bg" src="{{ asset('bootstrap-forum/images/signup-bg.png') }}" alt="bg">

            <div class="container">
                <div class="signup__container">
                    <div class="signup__logo">
                        <a href="#"><img src="{{ asset('bootstrap-forum/fonts/icons/main/Logo_Forum.svg') }}"
                                alt="logo">Unity</a>
                    </div>

                    <div class="signup__head">
                        <h3>Login to Unity Account</h3>
                        <p>By singin you can start posting, replaying to topics, earn badges, favorite, vote topics
                            and many more.</p>
                    </div>
                    <div class="signup__form">
                        <div class="signup__section">
                            <label class="signup__label" for="email">Email Address</label>
                            <input type="text" class="form-control" id="email" value="Jane326@gmail.com">
                        </div>
                        <div class="signup__section">
                            <label class="signup__label" for="password">Password</label>
                            <div class="message-input">
                                <input type="password" class="form-control" id="password" value="*********">
                            </div>
                        </div>
                        <a href="#" class="signup__btn-create btn btn--type-02">Login</a>
                    </div>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="signup__footer">
            <div class="container">
                <div class="signup__footer-content">
                    <ul class="signup__footer-menu">
                        <li><a href="#">Teams</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Send Feedback</a></li>
                    </ul>
                    <ul class="signup__footer-social">
                        <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-cloud" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('bootstrap-forum/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap-forum/vendor/velocity/velocity.min.js') }}"></script>
    <script src="{{ asset('bootstrap-forum/js/app.js') }}"></script>

</body>

</html>
