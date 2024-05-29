@props(['navigation' => true])

<!doctype html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Responsive HTML5 Template">
    <meta name="author" content="author.com">
    <title>DevSpaces - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('bootstrap-forum/fonts/icons/main/mainfont/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/fonts/icons/font-awesome/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('bootstrap-forum/vendor/bootstrap/v3/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/vendor/bootstrap/v4/bootstrap-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-forum/css/style.css') }}">
</head>
<body>
    <!-- HEADER -->
    @include('layout.header')

    <!-- MAIN -->
    <main>
        <div class="container">
            @if($navigation)
                <section id="navigation">
                    @include('layout.nav')
                </section>
            @endif
            <section id="content">
                @yield('content')
            </section>
        </div>
    </main>

    <!-- FOOTER -->
    @include('layout.footer')

    <!-- JAVA SCRIPT -->
    <script src="{{ asset('bootstrap-forum/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap-forum/vendor/velocity/velocity.min.js') }}"></script>
    <script src="{{ asset('bootstrap-forum/js/app.js') }}"></script>

</body>
</html>
