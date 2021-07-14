@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Gamedownload' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('gamedownloads.gamedownload.destroy', $gamedownload->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('gamedownloads.gamedownload.index') }}" class="btn btn-primary" title="Show All Gamedownload">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('gamedownloads.gamedownload.create') }}" class="btn btn-success" title="Create New Gamedownload">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('gamedownloads.gamedownload.edit', $gamedownload->id ) }}" class="btn btn-primary" title="Edit Gamedownload">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Gamedownload" onclick="return confirm(&quot;Delete Gamedownload??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($gamedownload->user)->id }}</dd>
            <dt>Game</dt>
            <dd>{{ optional($gamedownload->game)->id }}</dd>
            <dt>Created At</dt>
            <dd>{{ $gamedownload->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $gamedownload->updated_at }}</dd>
            <dt>Download Type</dt>
            <dd>{{ $gamedownload->download_type }}</dd>

        </dl>

    </div>
</div>

@endsection