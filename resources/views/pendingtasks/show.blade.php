@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Pendingtask' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('pendingtasks.pendingtask.destroy', $pendingtask->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('pendingtasks.pendingtask.index') }}" class="btn btn-primary" title="Show All Pendingtask">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('pendingtasks.pendingtask.create') }}" class="btn btn-success" title="Create New Pendingtask">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('pendingtasks.pendingtask.edit', $pendingtask->id ) }}" class="btn btn-primary" title="Edit Pendingtask">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Pendingtask" onclick="return confirm(&quot;Delete Pendingtask??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($pendingtask->user)->id }}</dd>
            <dt>Sender</dt>
            <dd>{{ optional($pendingtask->sender)->id }}</dd>
            <dt>Pending Task</dt>
            <dd>{{ $pendingtask->pending_task }}</dd>
            <dt>Created At</dt>
            <dd>{{ $pendingtask->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $pendingtask->updated_at }}</dd>
            <dt>Status</dt>
            <dd>{{ $pendingtask->status }}</dd>

        </dl>

    </div>
</div>

@endsection