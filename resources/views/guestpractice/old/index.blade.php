@extends('layouts.app')
@section('header_styles')


    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/guestpractice.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/nestable.css') }}">

    <link rel="stylesheet" href="{{asset("assets/css/chessboard-0.3.0.min.css")}}">
    <script src="{{asset("assets/js/chessboard-0.3.0.min.js")}}"></script>
    <script src="{{asset("assets/js/clock.js")}}"></script>

    <script src="{{asset("assets/js/compile.js")}}"></script>

@endsection
@section ('top')

    @php
        $countcorrectanswer=0;
        $countbadanswer=0;
    @endphp
    @if($question)
        @if(Session::has('countofcorrectanswer'.$question->exercise_id))
            @php

                $countcorrectanswer=session('countofcorrectanswer'.$question->exercise_id);
            @endphp
        @endif

        @if(Session::has('countofbadanswer'.$question->exercise_id))
            @php
                $countbadanswer=session('countofbadanswer'.$question->exercise_id);
            @endphp
        @endif
    @endif



    @include('guestpractice.practicevigation',[$exerciseset ])



@endsection
@section('content')

    <div class="panel panel-default">
        <div class="container">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                <a  href="#" id="passagebtn" data-target="#ShowpassageModal" data-toggle="modal" style="display: none;"  class="btn btn-edubtn "> Show passage </a>
            </div>
            <div style="display: none" id="hideAll">

                @if ($question)
                    @include ('guestpractice.question', [ $question,$exerciseset ,$nextquestionid,$countcorrectanswer   ])
                @else
                    There is no Question availble for your topic selection .
                @endif

            </div>
        </div>
    </div>


    <div class="modal fade " id="ShowpassageModal" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div  id="passageinfo"></div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        function myFunction(val) {
            document.getElementById("timeslider").innerHTML = val;
        }

    </script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.countdown360.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/practice.js') }}"></script>
    <script></script>
    <script>

        document.getElementById("hideAll").style.display = "block";
    </script>
    <script>



    </script>
@endsection

