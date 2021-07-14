@auth
<script>
    parent.$.fancybox.close();
    parent.location = "/home";
</script>
@endauth
@extends('layouts.app')
@auth
@section('top')
    <div class="panel-heading clearfix">
        <div class="container">
          <div class="tabbable-line"><ul class="nav nav-tabs "><li class="nolink">  Welcome {{Auth::user()->name}}</li></ul></div>
    </div>
    </div>
@endsection
@endauth
@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Homepage</div>





                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @else

                        @guest
                            @include('welcome')
                        @endguest
                        @auth

                            @if (Auth::User()->hasRole('Learner'))

                                @include('learner')
                            @elseif(Auth::User()->hasRole('Teacher'))
                                @include('teacher')
                            @elseif(Auth::User()->hasRole('Parent'))
                                @include('parent')
                            @endif
                        @endauth
                    @endif
                    Some code here?
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
