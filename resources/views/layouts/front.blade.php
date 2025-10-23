<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/logo.ico') }}" sizes="16x16">


    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    <style>
        body {
            /* Margin bottom by footer height */
            margin-bottom: 55px;
        }

        .footer {
            position: fixed;
            width: 100%;
            left: 0;
            bottom: 0;
            /* Set the fixed height of the footer here */
            height: 55px;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <div id="app">
        @include('front.components.header')

        <main role="main" class="flex-shrink-0">
            <div class="container-fluid mb-2">
                @include('components.alerts')

                @yield('content')
            </div>
        </main>
{{-- 
        <footer class="footer mt-auto bg-light">
            @include('front.components.footer')
        </footer> --}}
    </div>

    @stack('scripts')
</body>

</html>
