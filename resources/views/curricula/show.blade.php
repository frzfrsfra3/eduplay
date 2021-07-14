@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Curriculum' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('curricula.curriculum.destroy', $curriculum->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('curricula.curriculum.index') }}" class="btn btn-primary" title="Show All Curriculum">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('curricula.curriculum.create') }}" class="btn btn-success" title="Create New Curriculum">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('curricula.curriculum.edit', $curriculum->id ) }}" class="btn btn-primary" title="Edit Curriculum">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Curriculum" onclick="return confirm('Delete Curriculum?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Curriculum Name</dt>
            <dd>{{ $curriculum->curriculum_gradelist_name }}</dd>
            <dt>Description</dt>
            <dd>{{ $curriculum->description }}</dd>
            <dt>Country</dt>
            <dd>{{ optional($curriculum->country)->country_name }}</dd>
            <dt>Approve Status</dt>
            <dd>{{ $curriculum->approve_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $curriculum->createdby }}</dd>
            <dt>Updatedby</dt>
            <dd>{{ $curriculum->updatedby }}</dd>
            <dt>Created At</dt>
            <dd>{{ $curriculum->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $curriculum->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection