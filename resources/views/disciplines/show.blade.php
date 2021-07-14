@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Discipline' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('disciplines.discipline.destroy', $discipline->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('disciplines.discipline.index') }}" class="btn btn-primary" title="Show All Discipline">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('disciplines.discipline.create') }}" class="btn btn-success" title="Create New Discipline">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('disciplines.discipline.edit', $discipline->id ) }}" class="btn btn-primary" title="Edit Discipline">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Discipline" onclick="return confirm('Delete Discipline?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Discipline Name</dt>
            <dd>{{ $discipline->discipline_name }}</dd>
            <dt>Description</dt>
            <dd>{{ $discipline->description }}</dd>
            <dt>Curriculum</dt>
            <dd>{{ optional($discipline->curriculum)->curriculum_gradelist_name }}</dd>
            <dt>Iconurl</dt>
            <dd>{{ $discipline->iconurl }}</dd>
            <dt>Language Preference</dt>
            <dd>{{ optional($discipline->languagePreference)->id }}</dd>
            <dt>Approve Status</dt>
            <dd>{{ $discipline->approve_status }}</dd>
            <dt>Publish Status</dt>
            <dd>{{ $discipline->publish_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $discipline->createdby }}</dd>
            <dt>Updatedby</dt>
            <dd>{{ $discipline->updatedby }}</dd>
            <dt>Created At</dt>
            <dd>{{ $discipline->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $discipline->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection