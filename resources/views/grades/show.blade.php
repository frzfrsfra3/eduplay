@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Grade' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('grades.grade.destroy', $grade->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('grades.grade.index') }}" class="btn btn-primary" title="Show All Grade">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('grades.grade.create') }}" class="btn btn-success" title="Create New Grade">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('grades.grade.edit', $grade->id ) }}" class="btn btn-primary" title="Edit Grade">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Grade" onclick="return confirm('Delete Grade?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Grade Name</dt>
            <dd>{{ $grade->grade_name }}</dd>
            <dt>Curriculum</dt>
            <dd>{{ optional($grade->curriculum)->curriculum_gradelist_name }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $grade->createdby }}</dd>
            <dt>Created At</dt>
            <dd>{{ $grade->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $grade->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection