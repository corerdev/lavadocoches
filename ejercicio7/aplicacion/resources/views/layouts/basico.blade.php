<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/> 
  <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

  @yield('scripts')
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Trade+Winds&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css.css') }}">
  <title>@yield('title')</title>
</head>
<body>
  @include('layouts.menu')
  
    @yield('contenido')

</body>
</html>