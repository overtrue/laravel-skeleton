<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}" crossorigin="anonymous">
</head>
<body>
    <div id="app" class="d-flex flex-column">
        <div class="flex-fill d-flex flex-xl-nowrap">
            <o-sidebar v-if="$route.name.indexOf('auth') == -1"></o-sidebar>
            <div class="bg-content flex-fill p-0">
                <header v-if="$route.name.indexOf('auth') == -1">
                    <o-navbar></o-navbar>
                </header>
                <div class="px-2 pb-4 h-100">
                    <router-view />
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/dashboard.js') }}"></script>
</body>
</html>
