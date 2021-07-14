@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Notificationsaction' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('notificationsactions.notificationsaction.destroy', $notificationsaction->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('notificationsactions.notificationsaction.index') }}" class="btn btn-primary" title="Show All Notificationsaction">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('notificationsactions.notificationsaction.create') }}" class="btn btn-success" title="Create New Notificationsaction">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('notificationsactions.notificationsaction.edit', $notificationsaction->id ) }}" class="btn btn-primary" title="Edit Notificationsaction">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Notificationsaction" onclick="return confirm(&quot;Delete Notificationsaction??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Modelname</dt>
            <dd>{{ $notificationsaction->modelname }}</dd>
            <dt>Created At</dt>
            <dd>{{ $notificationsaction->created_at }}</dd>
            <dt>Notificationtpl</dt>
            <dd>{{ $notificationsaction->notificationtpl }}</dd>
            <dt>Type</dt>
            <dd>{{ $notificationsaction->type }}</dd>

        </dl>

    </div>
</div>

@endsection