@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Exercisesetbuyer' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('exercisesetbuyers.exercisesetbuyer.destroy', $exercisesetbuyer->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('exercisesetbuyers.exercisesetbuyer.index') }}" class="btn btn-primary" title="Show All Exercisesetbuyer">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('exercisesetbuyers.exercisesetbuyer.create') }}" class="btn btn-success" title="Create New Exercisesetbuyer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('exercisesetbuyers.exercisesetbuyer.edit', $exercisesetbuyer->id ) }}" class="btn btn-primary" title="Edit Exercisesetbuyer">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Exercisesetbuyer" onclick="return confirm(&quot;Delete Exercisesetbuyer??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Exerciseset</dt>
            <dd>{{ optional($exercisesetbuyer->exerciseset)->id }}</dd>
            <dt>User</dt>
            <dd>{{ optional($exercisesetbuyer->user)->id }}</dd>
            <dt>Joindate</dt>
            <dd>{{ $exercisesetbuyer->joindate }}</dd>

        </dl>

    </div>
</div>

@endsection