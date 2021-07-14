
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/css/bootstrap-tour.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/') }}/css/eduplay.css"/>

@endsection




@section('content')
    <div class="container" >


        <div class="col-md-9">
            <!-- Part1--->
            <div class="row"><h4>@lang('home.welcome_back') {{Auth::user()->name}}</h4></div>
            <div id="home-section-1">

                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 ri-padding" id="first-element">
                    <a href="{{route('users.user.addchildren',Auth::user())}}">

                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding div-main-button-container">
                                @lang('home.add_child')
                            </div>

                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12"  >
                                <img src="{{ asset('assets/images/') }}/manage-classes.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                            </div>
                        </div>
                    </a>
                </div>




                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 ri-padding" id="second-element">
                    <a href="{{route('exercisesets.exerciseset.index')}}">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding div-main-button-container">
                                @lang('home.buy_exercise')
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" >
                                <img src="{{ asset('assets/images/') }}/manage-exercise.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 ">


                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding div-main-home toggle" >
                        <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding div-main-button-container">
                            @lang('home.recommend_games')
                        </div>

                        <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" >
                            <img src="{{ asset('assets/images/') }}/manage-exam.png" style="padding: 10px;background-color: #ffffff;border-radius: 12px">
                        </div>
                    </div>

                </div>


            </div>
            <div class="clear-line"></div>
            <!-- End Part1 -->
            <!-- Part2-->
            <div class="row" style="padding-top: 20px"><h4>@lang('home.your_children')</h4></div>
            <div class="row">
                @if(count($childrens) == 0)
                    <div class="panel-body text-center">
                        <h4>@lang('home.havent_children')</h4>
                    </div>
                @else
                    @foreach($childrens as $child)
                        @php $times=$child->userloginactivities()->get()->last();
                                 $childbadges=$child->badges->last();
                             $childpendings=\App\Models\Pendingtask::with('user')->where('user_id', '=', $child->id)->get();
                            $color = '#'.dechex(rand(0x000000, 0xFFFFFF));
                        @endphp

                        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12  div-home">

                            <div class=" course-box-inline">
                                <div class="col-12 exercise-box">{{$child->name}}</div>
                                <div class="col-12 description-box">@lang('home.last_login') : {{ $times['created_at']}}</div>
                                @if ($childbadges)
                                    @if (strlen($childbadges->badgeimageurl) >0 && File::exists(public_path()."\assets\images\badges\\".$childbadges->badgeimageurl))
                                        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 child_badges_images"><img src="{{ asset('assets/images/badges/'.$childbadges->badgeimageurl) }}"></div>
                                    @endif
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12  child_badges_date"  style="padding-left: 15px;padding-right: 15px">@lang('home.date_acquired') <br> {{date('d - M - Y', strtotime( $childbadges->pivot->dateacquired ))}}</div>
                                @endif
                                <div class="clear-line"></div>
                                {{-- Child pending task --}}
                                @if(count($childpendings) == 0)
                                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 panel-body text-center">
                                        <h4>No Pending Tasks Available!</h4>
                                    </div>
                                @else
                                    <div >
                                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 child_pending_task">Pending Tasks Available</div>
                                        @foreach($childpendings as $childpending)
                                            <div>
                                            <a href="{{$childpending->pending_task_action}}" data-toggle="tooltip" title="{{$childpending->pending_task_description}}">

                                                {{ strlen($childpending->pending_task_description) > 33 ? substr($childpending->pending_task_description,0,31)."..." : $childpending->pending_task_description }}

                                            </a>
                                    </div>
                                        @endforeach
                                    </div>
                                @endif


                            </div>

                        </div>

                    @endforeach

                @endif


            </div>
            <!-- End Part2 -->

            <!-- Part4-->

            <!-- End Part4 -->
        </div>
        <div class="col-md-3 badges_obtained-header" style="background: #fafafa;">

                @include('pendingtask')

            </div>
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