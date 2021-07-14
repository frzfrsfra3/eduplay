@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Useractivitylog' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('useractivitylogs.useractivitylog.destroy', $useractivitylog->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('useractivitylogs.useractivitylog.index',$useractivitylog->id) }}" class="btn btn-primary" title="Show All Useractivitylog">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('useractivitylogs.useractivitylog.create',$useractivitylog->id) }}" class="btn btn-success" title="Create New Useractivitylog">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('useractivitylogs.useractivitylog.edit', $useractivitylog->id ) }}" class="btn btn-primary" title="Edit Useractivitylog">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Useractivitylog" onclick="return confirm(&quot;Delete Useractivitylog??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Created At</dt>
            <dd>{{ $useractivitylog->created_at }}</dd>
            <dt>Activity</dt>
            <dd>{{ optional($useractivitylog->activity)->activity_description }}</dd>
            <dt>User</dt>
            <dd>{{ optional($useractivitylog->user)->id }}</dd>
            <dt>Newpoints</dt>
            <dd>{{ $useractivitylog->newpoints }}</dd>
            <dt>Device</dt>
            <dd>{{ $useractivitylog->device }}</dd>
            <dt>Browserinformation</dt>
            <dd>{{ $useractivitylog->browserinformation }}</dd>

        </dl>

    </div>
</div>

@endsection