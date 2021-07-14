@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Skillmasterylevel' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('skillmasterylevels.skillmasterylevel.destroy', $skillmasterylevel->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('skillmasterylevels.skillmasterylevel.index') }}" class="btn btn-primary" title="Show All Skillmasterylevel">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('skillmasterylevels.skillmasterylevel.create') }}" class="btn btn-success" title="Create New Skillmasterylevel">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('skillmasterylevels.skillmasterylevel.edit', $skillmasterylevel->id ) }}" class="btn btn-primary" title="Edit Skillmasterylevel">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Skillmasterylevel" onclick="return confirm('Delete Skillmasterylevel?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Levelname</dt>
            <dd>{{ $skillmasterylevel->levelname }}</dd>
            <dt>Level Massage</dt>
            <dd>{{ $skillmasterylevel->level_massage }}</dd>
            <dt>Min Score</dt>
            <dd>{{ $skillmasterylevel->min_score }}</dd>
            <dt>Max Score</dt>
            <dd>{{ $skillmasterylevel->max_score }}</dd>
            <dt>Consecutive Value</dt>
            <dd>{{ $skillmasterylevel->consecutive_value }}</dd>
            <dt>Created At</dt>
            <dd>{{ $skillmasterylevel->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $skillmasterylevel->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection