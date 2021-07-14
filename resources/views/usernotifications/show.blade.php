@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Usernotification' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('usernotifications.usernotification.destroy', $usernotification->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('usernotifications.usernotification.index') }}" class="btn btn-primary" title="Show All Usernotification">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('usernotifications.usernotification.create') }}" class="btn btn-success" title="Create New Usernotification">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('usernotifications.usernotification.edit', $usernotification->id ) }}" class="btn btn-primary" title="Edit Usernotification">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Usernotification" onclick="return confirm(&quot;Delete Usernotification??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Receiver Userid</dt>
            <dd>{{ $usernotification->receiver_userid }}</dd>
            <dt>Sender Userid</dt>
            <dd>{{ $usernotification->sender_userid }}</dd>
            <dt>Notification</dt>
            <dd>{{ $usernotification->notification }}</dd>
            <dt>Action</dt>
            <dd>{{ optional($usernotification->action)->id }}</dd>
            <dt>Created At</dt>
            <dd>{{ $usernotification->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $usernotification->updated_at }}</dd>
            <dt>Status</dt>
            <dd>{{ $usernotification->status }}</dd>

        </dl>

    </div>
</div>

@endsection