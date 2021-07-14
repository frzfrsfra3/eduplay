@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'UserSkillmasterylevel' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('userskillmasterylevels.userskillmasterylevel.destroy', $userskillmasterylevel->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('userskillmasterylevels.userskillmasterylevel.index') }}" class="btn btn-primary" title="Show All User Skillmasterylevel">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('userskillmasterylevels.userskillmasterylevel.create') }}" class="btn btn-success" title="Create New User Skillmasterylevel">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('userskillmasterylevels.userskillmasterylevel.edit', $userskillmasterylevel->id ) }}" class="btn btn-primary" title="Edit User Skillmasterylevel">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User Skillmasterylevel" onclick="return confirm('Delete User Skillmasterylevel? ')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($userskillmasterylevel->user)->id }}</dd>
            <dt>Skill</dt>
            <dd>{{ optional($userskillmasterylevel->skill)->id }}</dd>
            <dt>Score</dt>
            <dd>{{ $userskillmasterylevel->score }}</dd>
            <dt>Mastery Level</dt>
            <dd>{{ $userskillmasterylevel->masteryLevel }}</dd>
            <dt>Created At</dt>
            <dd>{{ $userskillmasterylevel->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $userskillmasterylevel->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection