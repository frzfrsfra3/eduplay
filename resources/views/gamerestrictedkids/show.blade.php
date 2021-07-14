@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Gamerestrictedkid' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('gamerestrictedkids.gamerestrictedkid.destroy', $gamerestrictedkid->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('gamerestrictedkids.gamerestrictedkid.index') }}" class="btn btn-primary" title="Show All Gamerestrictedkid">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('gamerestrictedkids.gamerestrictedkid.create') }}" class="btn btn-success" title="Create New Gamerestrictedkid">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('gamerestrictedkids.gamerestrictedkid.edit', $gamerestrictedkid->id ) }}" class="btn btn-primary" title="Edit Gamerestrictedkid">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Gamerestrictedkid" onclick="return confirm(&quot;Delete Gamerestrictedkid??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Kid</dt>
            <dd>{{ optional($gamerestrictedkid->kid)->id }}</dd>
            <dt>Game</dt>
            <dd>{{ optional($gamerestrictedkid->game)->id }}</dd>
            <dt>Restricted By</dt>
            <dd>{{ optional($gamerestrictedkid->restrictedBy)->id }}</dd>
            <dt>Created At</dt>
            <dd>{{ $gamerestrictedkid->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $gamerestrictedkid->updated_at }}</dd>
            <dt>Isactive</dt>
            <dd>{{ $gamerestrictedkid->isactive }}</dd>

        </dl>

    </div>
</div>

@endsection