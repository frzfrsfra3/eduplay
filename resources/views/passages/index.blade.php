@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <style>.mce-menu {position:fixed !important}</style>
@endsection

@section('top')


    @include('myexercisesnavigation' ,[$ispublic=0])


@endsection

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">
        <div class="container" >

            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " style="margin-top: 10px ; padding-left: 0px ;padding-right: 0">
            <div class="pull-left ">
                <div class="passge-from-title" >List of Passages :</div>
                <br>
            </div>

            <div class="btn-group btn-group-sm pull-right  " role="group">
                <a href="{{ route('passages.passage.create' ,[$exercise_id]) }}" class="btn btn-edubtn" title="Create New Passage">
                    Create New Passage</span>
                </a>
            </div>

        </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 "  style=" padding-left: 0px ;padding-right: 0">
        @if(count($passages) == 0)
            <div class="panel-body text-center">
                <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 header-title">No Passage Available</div>
            </div>
        @else


            <div class="table-responsive" style="margin-bottom: 10px">

                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 title-row ">


                            <div  class="col-xl-2 col-lg-2 col-sm-2 col-xs-2">Passage Title</div>
                            <div  class="col-xl-4 col-lg-4 col-sm-4 col-xs-4">Passage Text</div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4">Exercise</div>
                              <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-2"></div>

                </div>



                    @foreach($passages as $passage)
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 alternative-row ">
                            <div  class="col-xl-2 col-lg-2 col-sm-2 col-xs-2">{{ $passage->passage_title }}</div>
                            <div  class="col-xl-4 col-lg-4 col-sm-4 col-xs-4">{!! $passage->passage_text  !!} </div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4">{{ optional($passage->exerciseset)->title }}</div>
                            <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-2" style="text-align: right">
                                 <a href="{{ route('passages.passage.show', $passage->id ) }}" class="btn btn-info" title="Show Passage">
                                   <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                 </a>
                                <a href="{{ route('passages.passage.edit', $passage->id ) }}" class="btn btn-primary" title="Edit Passage">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                                <a href="{{ route('passages.passage.destroy', $passage->id) }}" class="btn btn-danger"onclick="return confirm('Delete Passage?')" title="Delete Passage">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    @endforeach


            </div>
            </div>
        </div>

        <div class="panel-footer">
            {!! $passages->render() !!}
        </div>
        
        @endif
    </div>
    
    </div>
@endsection