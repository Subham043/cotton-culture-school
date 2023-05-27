<head>

    <meta charset="utf-8" />
    <title>JURYSOFT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="JURYSOFT - Admin Panel" name="description" />
    <meta content="JURYSOFT - Admin Panel" name="author" />
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/logo.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('admin/js/layout.js') }}"></script>

    <!-- App Css-->
    @vite(['resources/admin/css/main.css'])

    @yield('css')
</head>
