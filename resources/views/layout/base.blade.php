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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

</head>

<body>
    <!-- HEADER -->
    @include('layout.header')

    <!-- MAIN -->
    <main>
        <div class="container">
            @if ($navigation)
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('bootstrap-forum/vendor/velocity/velocity.min.js') }}"></script>
    <script src="{{ asset('bootstrap-forum/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script type="module" src="{{ asset('plugin/summernote/summernote-at-mention/src/summernote-at-mention.js') }}"></script>
    <script type="module" src="{{ asset('plugin/summernote/summernote-at-mention/src/selection-preserver.js') }}"></script>
    <script src="{{ asset('plugin/summernote/summernote-highlight/dist/summernote-ext-highlight.min.js') }}"></script>
    <script>
        $('.summernotes').each(function() {
            var placeholder = $(this).data('placeholder')
            $(this).summernote({
                height: 200,
                placeholder: placeholder,
                tabsize: 2,
                lang: 'en-EN'
            })
        });

        function applySummernoteReplyBox() {
            $('.comments-editor').each(function() {
                var placeholder = $(this).data('placeholder')
                var userLists = {!! json_encode($users->toArray()) !!}
                var mentionData = []

                $(this).summernote({
                    height: 200,
                    placeholder: placeholder,
                    tabsize: 2,
                    lang: 'en-EN',
                    prettifyHtml: false,
                    toolbar: [
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                        ['highlight', ['highlight']],
                    ],
                    codemirror: {
                        mode: 'htmlmixed',
                        lineNumbers: 'true',
                        theme: 'monokai',
                    },
                    hint: {
                        mentions: userLists,
                        match: /\B@(\w*)$/,
                        search: function(keyword, callback) {
                            callback($.grep(this.mentions, function(item) {
                                return item.first_name.toLowerCase().indexOf(keyword
                                    .toLowerCase()) === 0;
                            }));
                        },
                        template: function(item) {
                            return `<img src="${item.avatar}" width="20" /> ${item.first_name}`;
                        },
                        content: function(item) {
                            mentionData.push(item.id);
                            $('#mentionInput').val(JSON.stringify(mentionData));
                            return $(`<span class="fw-bold">@${item.first_name}&nbsp;</span>`)[0];
                        }
                    }
                })
            })
        }
    </script>

    @stack('script')

    <script>
        $(document).ready(function () {
            $('pre').each(function () {
                $(this).css({
                    "color": "#f7a124",
                    "background-color": "rgb(245 245 245)",
                    "padding": "15px",
                    "border-radius": "5px",
                    "width": "100%"
                })
            })
        })
    </script>


</body>

</html>
