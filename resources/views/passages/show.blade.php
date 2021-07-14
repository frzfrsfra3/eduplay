@extends('layouts.app')

@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nestable.css') }}">
@endsection
@section('top')


    @include('myexercisesnavigation' ,[$ispublic=0 ,$exerciseset =$passage->exerciseset])



@endsection

@section('content')

<div class="panel panel-default">
    <div class="container" >
        <div class="exerciseset-form" id="exerciseset-form">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="exerciseset-details" >
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding"  style="">
                    <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 header-title">Passage Details</div>
                    <div class="pull-right">

                        <form method="POST" action="{!! route('passages.passage.destroy', $passage->id) !!}" accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('passages.passage.index' ,[$passage->exerciseset->id]) }}" class="btn btn-primary" title="Show All Passage">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>

                                <a href="{{ route('passages.passage.create' ,[$passage->exerciseset->id]) }}" class="btn btn-success" title="Create New Passage">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>

                                <a href="{{ route('passages.passage.edit' , $passage->id ) }}" class="btn btn-primary" title="Edit Passage">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>

                                <button type="submit" class="btn btn-danger" title="Delete Passage" onclick="return confirm('Delete Passage?')">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>

                    </div>
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box" >
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-title"> {{ $passage->passage_title }}</div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">

                        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 exercise-description"> {!!  nl2br($passage->passage_text)  !!}</div>
                    </div>
                </div>
                @include('questions.exercise_question_public',[$questions =$passage->questions()->paginate(5)])


    </div>
</div>
            </div>
        </div>
    </div>
</div>

@endsection