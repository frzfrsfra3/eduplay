@extends('layouts.app')

@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
@endsection

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
@section('top')
    <div class="panel-heading clearfix">
        <div class="container">
            @include('privatelibnavigation',[$active=1])
        </div>
    </div>
@endsection
@section('content')

<div class="panel panel-default">
<div class="container">

    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">

            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12">

            </div><!-- /.col-lg-6 -->
            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 all-padding">
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 le-padding" >
             <form action="" method="GET" >
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 input-group search-box" >
                <input type="text" class=" search-input" placeholder="@lang('exercisesets.search_exercisesetes')" name="searchkey">
                <span class="input-group-btn"><button class="btn btn-search " type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></span>
            </div>
             </form></div>
                <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-12 le-padding"  style="margin: 5px 0 0 -10px">
                <a href="{{ route('exercisesets.exerciseset.create') }}" class="btn btn-edubtn" title="Create New Exerciseset">
                    <span class="" aria-hidden="true">Create</span>
                </a>
                </div>

    </div>


    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="exerciseset">

        <div  id="exerciseset-header">
            My Exercise <a href="{{ route('exercisesets.exerciseset.create') }}" class=" btn-add" title="Create New Exerciseset" style="border: 0">+</a>
        </div>
        @if(count($myexercises) == 0)
            <div class="panel-body ">
                <h4>No Exercisesets Available!</h4>
            </div>
        @else
                 @foreach($myexercises as $exerciseset)
                    <div class=" col-xl-4 col-lg-4 col-sm-6 col-xs-12   le-padding">
                    @include('exercisesets.single-box' ,[$ispublic=0 ])
                    </div>
                 @endforeach




        @endif
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="exerciseset">
        <div  id="exerciseset-header">
            Followed from public library <a href="{{ route('exercisesets.exerciseset.index') }}" class=" btn-add" title="Create New Exerciseset" style="border: 0">+</a>
        </div>
        @if(count($exercisesbuy) == 0)
            <div class="panel-body ">
                <h4>No Followed Exercise Available!</h4>
            </div>
        @else

            @foreach($exercisesbuy as $exerciseset)
                <div class=" col-xl-4 col-lg-4 col-sm-6 col-xs-12   le-padding">
                    @include('exercisesets.single-box' ,[$ispublic=0 ])
                </div>
            @endforeach




        @endif
    </div>
    </div>
</div>
@endsection


@section('footer_scripts')


@endsection
