@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Xp Point' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('xp_points.xp_point.destroy', $xpPoint->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('xp_points.xp_point.index') }}" class="btn btn-primary" title="Show All Xp Point">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('xp_points.xp_point.create') }}" class="btn btn-success" title="Create New Xp Point">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('xp_points.xp_point.edit', $xpPoint->id ) }}" class="btn btn-primary" title="Edit Xp Point">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Xp Point" onclick="return confirm('Delete Xp Point?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Activity Name</dt>
            <dd>{{ $xpPoint->activity_name }}</dd>
            <dt>Point</dt>
            <dd>{{ $xpPoint->point }}</dd>

        </dl>

    </div>
</div>

@endsection