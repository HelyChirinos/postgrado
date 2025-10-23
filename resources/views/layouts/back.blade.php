<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-96x96.png') }}" sizes="96x96">

    @vite(['resources/js/app.js', 'resources/js/datatables.js', 'resources/js/custom.js', 'resources/sass/app.scss', 'resources/sass/deferred.scss'])

    <style>
        .modal-header {
            padding: 1rem 1.35rem;
                margin-bottom: 0;
                background-color:#274D8F;
                color: white;
                border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }

    </style>
    @stack('styles')
</head>

<body class="d-flex flex-column h-100">
    <div id="app">
        @include('back.components.header')

        <div class="container">

            <main role="main" class="flex-shrink-0">
                <div class="container-fluid mb-2">
                    @include('components.alerts')

                    @yield('content')
                </div>
            </main>
        </div> 
    </div>
    @stack('scripts')

    <script type="module">
        /* -------------------------------------------------------------------------------------------- */
        (() => {
            'use strict'

            const getStoredTheme = () => localStorage.getItem('theme')
            const setStoredTheme = theme => localStorage.setItem('theme', theme)

            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                
                if (storedTheme) {
                    return storedTheme
                }

                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            const setTheme = theme => {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark')
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                }
            }

            setTheme(getPreferredTheme())


            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme()

                if (storedTheme !== 'light' && storedTheme !== 'dark') {
                    setTheme(getPreferredTheme())
                }
            })


        })()
        /* -------------------------------------------------------------------------------------------- */
    </script>


</body>

</html>
