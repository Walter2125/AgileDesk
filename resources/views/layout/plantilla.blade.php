<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons-fixed.css') }}">

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    @yield('content')

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <!-- Los scripts de Popper y Bootstrap adicionales ya están incluidos en bootstrap.bundle.min.js -->
    -->

    
  </body>
</html>