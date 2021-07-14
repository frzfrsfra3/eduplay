
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/css/bootstrap-tour.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/css/eduplay.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/disciplines.css') }}">
@endsection




@section('content')
    <div class="container">
        <div class="col-md-9">
            <!-- Part1--->
            <div class="row"><h4>@lang('home.eduplaycloud') <a href="#" id="start-tour">@lang('home.you_can_do')</a></h4></div>
            <div id="home-section-1" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">
                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 ri-padding" id="first-element">
                    <a href="{{route('courseclasses.courseclass.myclasses')}}">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding div-main-button-container">
                                Manage <br> Classes
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12"  >
                                <img src="{{ asset('assets/images/') }}/manage-classes.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                            </div>


                        </div></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12   ri-padding" id="second-element">
                    <a href="{{route('exercisesets.exerciseset.private')}}">
                         <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                              <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding div-main-button-container">
                                  @lang('home.manage_exercise')
                            </div>

                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" >
                                <img src="{{ asset('assets/images/') }}/manage-exercise.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                            </div>
                         </div></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12  ">
                    <a href="{{ route('exams.exam.index') }}">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                            <div class="col-xl-7 col-lg-7 col-sm-7 col-xs-12 all-padding div-main-button-container">
                                @lang('home.manage_study')
                            </div>

                            <div class="col-xl-5 col-lg-5 col-sm-5 col-xs-12" >
                                <img src="{{ asset('assets/images/') }}/manage-exam.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="clear-line"></div>
            <!-- End Part1 -->
            <!-- Part2-->
            <div class="row" style="padding-top: 20px"><h4>@lang('home.featured_discipline')</h4></div>
            <div class="slider responsive" id="third-element">
                @if(count($disciplines) == 0)
                    <div class="panel-body ">
                        <h4>No Disciplines Available!</h4>
                    </div>
                @else
                    @foreach($disciplines as $discipline)
                        <div>
                            <div class="div-carousel-home text-center">
                                <a href="{{ route('knowledgemap.index', $discipline->id ) }}" >
                                    @include ('disciplines.oneelemnet' )</a>
                            </div>
                        </div>
                    @endforeach

                @endif

            </div>
            <!-- End Part2 -->
            <!-- Part3-->
            <div class="row" style="padding-top: 10px;"><h4>Exercises you may be interested in.</h4></div>
            <div class="slider responsive" id="exerciseset">
                @foreach($exercisesets as $exerciseset)
                    <div>
                        <div class="div-carousel-home">
                            @include('exercisesets.single-box' ,[$ispublic=1])
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- End Part3 -->
            <!-- Part4-->

            <!-- End Part4 -->
        </div>
        <div class="col-md-3 badges_obtained-header" style="background: #fafafa;">
            @include('pendingtask')

        </div>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/homepage.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-tour.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('.toggle').hover(function(){
            $(this).toggleClass('div-main-home div-main-home-hover');
        });
    </script>
@endsection
