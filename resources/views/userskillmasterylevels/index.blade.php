@extends('layouts.app')

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
                <h4 class="mt-5 mb-5">UserSkillmasterylevels</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('userskillmasterylevels.userskillmasterylevel.create') }}" class="btn btn-success" title="Create New User Skillmasterylevel">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($userskillmasterylevels) == 0)
            <div class="panel-body text-center">
                <h4>No User Skillmasterylevels Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Skill</th>
                            <th>Score</th>
                            <th>Mastery Level</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userskillmasterylevels as $userskillmasterylevel)
                        <tr>
                            <td>{{ optional($userskillmasterylevel->user)->id }}</td>
                            <td>{{ optional($userskillmasterylevel->skill)->id }}</td>
                            <td>{{ $userskillmasterylevel->score }}</td>
                            <td>{{ $userskillmasterylevel->masteryLevel }}</td>

                            <td>

                                <form method="POST" action="{!! route('userskillmasterylevels.userskillmasterylevel.destroy', $userskillmasterylevel->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('userskillmasterylevels.userskillmasterylevel.show', $userskillmasterylevel->id ) }}" class="btn btn-info" title="Show User Skillmasterylevel">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('userskillmasterylevels.userskillmasterylevel.edit', $userskillmasterylevel->id ) }}" class="btn btn-primary" title="Edit User Skillmasterylevel">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete User Skillmasterylevel" onclick="return confirm('Delete User Skillmasterylevel?')">
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
            {!! $userskillmasterylevels->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection