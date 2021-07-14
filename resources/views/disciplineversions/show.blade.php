@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Disciplineversion' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('disciplineversions.disciplineversion.destroy', $disciplineversion->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('disciplineversions.disciplineversion.index') }}" class="btn btn-primary" title="Show All Disciplineversion">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('disciplineversions.disciplineversion.create') }}" class="btn btn-success" title="Create New Disciplineversion">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('disciplineversions.disciplineversion.edit', $disciplineversion->id ) }}" class="btn btn-primary" title="Edit Disciplineversion">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Disciplineversion" onclick="return confirm(&quot;Delete Disciplineversion??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Discipline</dt>
            <dd>{{ optional($disciplineversion->discipline)->discipline_name }}</dd>
            <dt>Version</dt>
            <dd>{{ $disciplineversion->version }}</dd>
            <dt>Ispublished</dt>
            <dd>{{ $disciplineversion->ispublished }}</dd>
            <dt>Created At</dt>
            <dd>{{ $disciplineversion->created_at }}</dd>

        </dl>

    </div>
</div>

@endsection