@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Exercise' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('admin.exercise.destroy', $exerciseset->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('admin.exercise.index') }}" class="btn btn-primary" title="Show All exercise">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('admin.exercise.create') }}" class="btn btn-success" title="Create New exercise">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('admin.exercise.edit', $exerciseset->id ) }}" class="btn btn-primary" title="Edit exercise">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete exercise" onclick="return confirm(&quot;Delete exercise??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd>{{ $exerciseset->title }}</dd>
            <dt>Description</dt>
            <dd>{{ $exerciseset->description }}</dd>
            <dt>Exerciseset Image</dt>
            <dd>      <img class="avatar-pic" src="{{ asset('/uploads/exercisesets') }}/{{ $exerciseset->exerciseset_image }}" width="100px"></dd>
            <dt>Price</dt>
            <dd>{{ $exerciseset->price }}</dd>
            <dt>Minimum Age</dt>
            <dd>{{ $exerciseset->minimum_age }}</dd>
            <dt>Maximum Age</dt>
            <dd>{{ $exerciseset->maximum_age }}</dd>
            <dt>Topic</dt>
            <dd>{{ optional($exerciseset->topics)->topic_name }}</dd>
            <dt>Discipline</dt>
            <dd>{{ optional($exerciseset->discipline)->discipline_name }}</dd>
            <dt>Grade</dt>
            <dd>{{ optional($exerciseset->grade)->grade_name }}</dd>
            <dt>language</dt>
            <dd>{{ optional($exerciseset->language)->language }}</dd>
            <dt>Publish Status</dt>
            <dd>{{ $exerciseset->publish_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ optional($exerciseset->owner)->name }}</dd>
            <dt>Created At</dt>
            <dd>{{ $exerciseset->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $exerciseset->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection