<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
{{-- CSS --}}
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/mdb.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
{{-- JS --}}
<script src="/js/app.js"></script>
<script src="/js/jquery-3.3.1.min.js"></script>
@yield('heads')
</head>
<body>

<div id="app" class="container-fluid">
@include('layouts.navigation')

@yield('content')

</div>

<script src="/js/mdb.min.js"></script>
@yield('scripts')
</body>
</html>
