@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Activity' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('activities.activity.destroy', $activity->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('activities.activity.index') }}" class="btn btn-primary" title="Show All Activity">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('activities.activity.create') }}" class="btn btn-success" title="Create New Activity">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('activities.activity.edit', $activity->id ) }}" class="btn btn-primary" title="Edit Activity">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Activity" onclick="return confirm('Delete Activity')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Activity Description</dt>
            <dd>{{ $activity->description }}</dd>

        </dl>

    </div>
</div>

@endsection