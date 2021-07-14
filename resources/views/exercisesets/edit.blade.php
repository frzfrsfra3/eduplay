@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-toggle.min.css') }}">
@endsection

@section('top')

        @include('myexercisesnavigation' , [$ispublic=0])


@endsection
@section('content')

    <div class="panel panel-default">

        <div  class="container">
            <div class="exerciseset-form" id="exerciseset-form">


                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ route('exercisesets.exerciseset.update', $exerciseset->id) }}" id="edit_exerciseset_form" name="edit_exerciseset_form" accept-charset="UTF-8" class="form-horizontal">
                            <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 header-title">
                                @lang('exercisesets.edit_new_exercise')</div>
                            <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-12" style="text-align: right"> <input class="btn btn-edubtn" type="submit" value="Update"></div>
                            {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box">
                                @include ('exercisesets.form', [
                                                      'exerciseset' => $exerciseset,
                                                    ])
                            </div>


                        </form>

            </div>
        </div >
    </div>


@endsection