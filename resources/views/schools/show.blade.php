@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'School' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('schools.school.destroy', $school->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('schools.school.index') }}" class="btn btn-primary" title="Show All School">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('schools.school.create') }}" class="btn btn-success" title="Create New School">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('schools.school.edit', $school->id ) }}" class="btn btn-primary" title="Edit School">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete School" onclick="return confirm(&quot;Delete School??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>School Name</dt>
            <dd>{{ $school->school_name }}</dd>
            <dt>Address</dt>
            <dd>{{ $school->address }}</dd>
            <dt>Created At</dt>
            <dd>{{ $school->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $school->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection