@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/disciplines.css') }}">
@endsection
@section('top')
    <div class="panel-heading clearfix">
        <div class="container">

            @include('explorenavigation',[$active=1])
        </div>
    </div>
@endsection

@section('content')
    <div class="panel panel-default">
       <div class="container">
           <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 le-padding" >
               <div  class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 all-padding" ></div>
               <!-- /.col-lg-6 -->
                <div class="col-xl-4 col-lg-4 col-sm-6 col-xs-12 " style="padding-right: 0">
                    <form action="" method="GET">


                        <div  class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 input-group search-box" >
                            <input type="text" class=" search-input" placeholder="@lang('disciplines.search_disciplines')" name="searchkey">
                            <span class="input-group-btn">
                                <button class="btn btn-search" type="submit"><i class="fa fa-search" aria-hidden="true" style="color: #3ec1de"></i></button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                </div><!-- /.col-lg-6 -->


        </div>

        @if(Session::has('success_message'))
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok"></span>
                    {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                             <span aria-hidden="true">&times;</span>
                        </button>

            </div>
        @endif

        @if(count($disciplines) == 0)
            <div class="panel-body text-center">
                <h4>No Disciplines Available!</h4>
            </div>
        @else
            <ul>
                    @foreach($disciplines as $discipline)
                    <li class=" col-xl-4 col-lg-4 col-sm-6 col-xs-12  disipline_box">
                        @include ('disciplines.oneelemnet' )
                    </li>
                    @endforeach
            </ul>
        @endif


        </div>
        <div class="panel-footer"></div>
       </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="/js/jquery.jscroll.min.js"></script>
    <script>
        function requestDiscipline(disId) {
            $.ajax({
                url: "{{route('disciplinecollaborators.disciplinecollaborator.requestdiscipline')}}",
                type: 'get',
                data: {'disId':disId},
                success: function (data) {
                    alert(data);
                    window.location.reload();
                }

            });
        }

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection