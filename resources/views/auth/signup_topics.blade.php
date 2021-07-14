@php
    if (isset($_GET['popup'])){
    $view="popup";$p=1;$lnk="?popup=y";}
    else
    { $view="popup";$p=2;$lnk="";}
@endphp
@extends('layouts/'.$view)
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
<style>
    .thumbnail{padding: 0!important;margin-bottom: 0 !important;background-color: transparent !important;}


</style>

@stop
{{-- Page title --}}
@section('title')
    Sign up
    @parent
@stop

@section('content')

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " >
            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 left-bar all-padding"  >
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 signup-page1">
                    helping every student succeed with personalized practice. 100% free



                </div>

            </div>



            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 right-bar all-padding">
                 <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 right-bar-box" >

                         <form id="login-form" class="login-form" action="{{ route('signup_topics.signup') }}" method="post" role="form">
                             {{ csrf_field() }}

                        @foreach($topics as $topic)
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4  ri-padding">
                                <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;text-align: center ">
                                    <div class="image-checkbox thumbnail">
                                    @if (strlen($topic->iconurl)==0)
                                        <img  src={{asset('assets/images/topic_default-test.png')}} alt="" >
                                    @else
                                        <img  src={{asset('assets/images/'.$topic->iconurl)}} alt="" >
                                    @endif
                                        <input type="checkbox" name="bit_topics[]" id="bit_topics[{{$topic->id}}]" value="{{$topic->id}}"  />
                                </div>


                                    <span style="text-align: center ;color:#00b6f1 ;font-size: 18px" >{{$topic->topic_name}}</span>

                                </div>
                            </div>
                        @endforeach
                        <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12  all-padding " >

                            <input type="submit" class="btn icon-btn1 btn-mylogin" value="Select Your Topics" id="submitlogin" name="submitlogin">
                            <div class="alert alert-danger fade" id="invaliderror" style="display:none;"></div>
                        </div>

                     </form>
                 </div>
            </div>
        </div>

@endsection

@section('footer_scripts')

    <script>

        function facebookclose(url){

            parent.location = url;
        }


    </script>
    <script type="text/javascript">
        jQuery(function ($) {
            // init the state from the input
            $(".image-checkbox").each(function () {
                if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                    $(this).addClass('image-checkbox-checked');
                }
                else {
                    $(this).removeClass('image-checkbox-checked');
                }
            });

            // sync the state to the input
            $(".image-checkbox").on("click", function (e) {
                if ($(this).hasClass('image-checkbox-checked')) {
                    $(this).removeClass('image-checkbox-checked');
                    $(this).find('input[type="checkbox"]').first().removeAttr("checked");
                }
                else {
                    $(this).addClass('image-checkbox-checked');
                    $(this).find('input[type="checkbox"]').first().attr("checked", "checked");
                }

                e.preventDefault();
            });
        });
    </script>
@endsection