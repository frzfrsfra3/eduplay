<!doctype html>
<html >
    <head>
        <title>
          EduPlayCloud.com - @section('title')
        @show
    </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/eduplaycloud/image/favicon.ico') }}">
		<!-- Fonts
		============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<!-- CSS  -->
		<!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<!-- responsive CSS
		============================================ -->
         <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <!-- font-awesome CSS
 ============================================ -->
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.css') }}">
         <!--page level css-->
            @yield('header_styles')
        <!--end of page level css-->
    </head>

<body>
    <!-- Header Start -->

    <!-- slider / breadcrumbs section -->
    @yield('top')
    <!-- Content -->
    @yield('content')

    <!--global js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


    <script>
        function facebookclose(url){
        parent.$.fancybox.close();
            parent.location = url;
        }
    </script>
    <!--global js end-->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->
</body>

</html>
