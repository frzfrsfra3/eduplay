@extends('layouts.admin')
@section('header_styles')
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

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Avatars</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('avatars.avatar.create') }}" class="btn btn-success" title="Create New Avatar">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($avatars) == 0)
            <div class="panel-body text-center">
                <h4>No Avatar Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Points</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($avatars as $avatar)
                        <tr>
                            <td> {{$avatar->name}}</td>
                            <td>
                            <img src="{{ asset('assets/eduplaycloud/image/'.$avatar->image) }}" width="100px">
                            </td>
                            <td> {{$avatar->category}}</td>
                            <td> {{$avatar->points}}</td>
                            <td>
                            </td>
                            <td>
                                <form method="POST" action="{!! route('avatars.avatar.destroy', $avatar->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        {{-- <a href="{{ route('skills.skill.show', $avatar->id ) }}" class="btn btn-info" title="Show Skill">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a> --}}
                                        <a href="{{ route('avatars.avatar.edit', $avatar->id ) }}" class="btn btn-primary" title="Edit Avatar">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                        <button type="submit" class="btn btn-danger" title="Delete Avatar" onclick="return confirm(&quot;Delete Avatar?;&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
             {!! $avatars->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection