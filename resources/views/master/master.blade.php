<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/fontawesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/bsadmin.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/dataTables.bootstrap4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/spin.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/customTableResponsive.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/select2-bootstrap4.min.css') !!}">
    @yield('additionalCSS')
</head>
<body>
@include('master.navbar')
<div class="d-flex">
    @include('master.sidebar')
    <div class="container-fluid p-2">
      @yield('content')
    </div>
</div>

<script src="{!! asset('js/jquery.min.js') !!}"></script>
<script src="{!! asset('js/popper.min.js') !!}"></script>
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/bsadmin.js') !!}"></script>
<script src="{!! asset('js/tanggalConvert.js') !!}"></script>
<script src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script src="{!! asset('js/select2.min.js') !!}"></script>
@yield('additionalJS')
</body>
</html>
