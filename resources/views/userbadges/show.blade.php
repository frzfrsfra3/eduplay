@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Userbadge' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('userbadges.userbadge.destroy', $userbadge->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('userbadges.userbadge.index') }}" class="btn btn-primary" title="Show All Userbadge">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('userbadges.userbadge.create') }}" class="btn btn-success" title="Create New Userbadge">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('userbadges.userbadge.edit', $userbadge->id ) }}" class="btn btn-primary" title="Edit Userbadge">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Userbadge" onclick="return confirm(&quot;Delete Userbadge??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($userbadge->user)->id }}</dd>
            <dt>Badge</dt>
            <dd>{{ optional($userbadge->badge)->badgetitle }}</dd>
            <dt>Dateacquired</dt>
            <dd>{{ $userbadge->dateacquired }}</dd>

        </dl>

    </div>
</div>

@endsection