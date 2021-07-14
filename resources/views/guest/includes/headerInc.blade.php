@if(Session::has('local'))
    @php($lang = session('local'))
@else
    @php($lang = 'en')
@endif
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=0/">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,600i,700,700i,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cairo:200,300,400,600,700,900&display=swap" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
{{--  <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/fonts.css') }}" media="all" type="text/css">  --}}
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/bootstrap.min.css') }}" media="all" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/style.css') }}" media="all" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/bootstrap-datetimepicker.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/bootstrap-select.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/css/style.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/css/dev.css') }}" type="text/css" media="all">
@if ($lang == 'ar')
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/rtl.css') }}" media="all" type="text/css">
@endif
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/eduplaycloud/image/favicon.ico') }}">

{{-- {{base_path('/')}} --}}
{{-- <script type="text/javascript" src="{{ str_replace('public/', '', URL('resources/lang/js/'.$lang.'/messages.js')) }}"></script> --}}
{{-- <script type="text/javascript" src="{{ URL('/resources/lang/js/'.$lang.'/messages.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/lang/js/'.$lang.'/messages.js') }}"></script>
<script> var site_url = '{{ URL('/') }}'; </script>