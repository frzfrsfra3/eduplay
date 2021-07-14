@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Inviteduser' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('invitedusers.inviteduser.destroy', $inviteduser->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('invitedusers.inviteduser.index') }}" class="btn btn-primary" title="Show All Inviteduser">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('invitedusers.inviteduser.create') }}" class="btn btn-success" title="Create New Inviteduser">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('invitedusers.inviteduser.edit', $inviteduser->id ) }}" class="btn btn-primary" title="Edit Inviteduser">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Inviteduser" onclick="return confirm(&quot;Delete Inviteduser??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Email</dt>
            <dd>{{ $inviteduser->email }}</dd>
            <dt>Invitedby</dt>
            <dd>{{ $inviteduser->invitedby }}</dd>
            <dt>Message</dt>
            <dd>{{ $inviteduser->message }}</dd>
            <dt>Invitationtype</dt>
            <dd>{{ $inviteduser->invitationtype }}</dd>
            <dt>Invitationstatus</dt>
            <dd>{{ $inviteduser->invitationstatus }}</dd>
            <dt>Isinvitedregistered</dt>
            <dd>{{ ($inviteduser->isinvitedregistered) ? 'Yes' : 'No' }}</dd>
            <dt>Discipline</dt>
            <dd>{{ optional($inviteduser->discipline)->discipline_name }}</dd>
            <dt>Created At</dt>
            <dd>{{ $inviteduser->created_at }}</dd>

        </dl>

    </div>
</div>

@endsection