@extends('layouts.app')

@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.1.7.5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/exam.css') }}">

@endsection

@section('top')
    @include('myexamsnavigation')
@endsection
@section('content')

    <div class="panel panel-default">

       <div class="panel-body">
           <div class="container">
               <div class="exerciseset-form" id="exerciseset-form">
           @if ($errors->any())
               <ul class="alert alert-danger">
                   @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           @endif


                    <form method="POST" action="{{ route('exams.exam.store') }}"  accept-charset="UTF-8" id="create_exam_form" name="create_exam_form" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 header-title ">
                          Exam details:</div>

                        <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-12 header-bottun" >
                            <a href="{{route ('exams.exam.selectquestions')}}" class="btn btn-edubtn">Back</a>
                            <input class="btn btn-edubtn" type="submit" value="Save Exam"></div>

                        <input name="_method" type="hidden" value="PUT">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box" >


            @include ('exams.form_create', [
                                        'exam' => null,
                                      ])



                        </div>
            </form>
            </div>
           </div>
        </div>
    </div>

@endsection
@section('footer_scripts')

    <script>
        sessionStorage.setItem("getquestionVisited", "True");
    </script>

    <script>
        $(document).on("change", ".mark-value", function() {

            var sum = 0;
            $(".mark-value").each(function(){
                sum += +$(this).val();
            });
            $(".total-mark").text(sum);

            //alert(sum);
        });

    </script>

@endsection


