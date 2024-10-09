<!doctype html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    {{-- feater icons --}}
    <link href="{{ asset('assets/css/phoenix.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    {{-- select choosen --}}
    {{-- <link href="assets/chosen/chosen.css" rel="stylesheet"> --}}
    <link href="{{ asset('assets/chosen/chosen.min.css') }}" rel="stylesheet">

    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

{{-- header --}}

<body>
    <main class="main" id="top">
        <div class="container-fluid px-0">

            {{-- sidebar --}}
            @include('template.partials.sidebar')
            {{-- sidebar --}}

            {{-- navbar --}}
            @include('template.partials.navbar')
            {{-- navbar --}}

            {{-- content --}}

            {{-- @if (Auth::user()->role == 'developer')
                @include('pages.dev.index');
            @elseif (Auth::user()->role == 'administrator')
                @include('pages.admin.index');
            @elseif (Auth::user()->role == 'member')
                @include('pages.member.index');
            @elseif (Auth::user()->role == 'individu')
                @include('pages.user.index');
            @endif --}}

            @yield('content')

            {{-- @include('pages.user.index') --}}
            {{-- content --}}

        </div>
    </main>

    {{-- feater icons --}}
    <script src="{{ asset('assets/js/phoenix.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce-dashboard.js') }}"></script>

    {{-- jquery --}}
    <script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>

    {{-- select choosen --}}
    <script src="{{ asset('assets/chosen/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/chosen/chosen.jquery.js') }}"></script>
    <script>
        $(".selectchosen").chosen({
            width: "100%"
        });
    </script>
    @stack('scripts')


</body>

</html>
