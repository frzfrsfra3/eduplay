@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Topic' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('topics.topic.destroy', $topic->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('topics.topic.index') }}" class="btn btn-primary" title="Show All Topic">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('topics.topic.create') }}" class="btn btn-success" title="Create New Topic">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('topics.topic.edit', $topic->id ) }}" class="btn btn-primary" title="Edit Topic">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Topic" onclick="return confirm('Delete Topic')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Topic Name</dt>
            <dd>{{ $topic->topic_name }}</dd>
            <dt>Discipline</dt>
            <dd>{{ optional($topic->discipline)->discipline_name }}</dd>
            <dt>Approve Status</dt>
            <dd>{{ $topic->approve_status }}</dd>
            <dt>Publish Status</dt>
            <dd>{{ $topic->publish_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $topic->createdby }}</dd>
            <dt>Updatedby</dt>
            <dd>{{ $topic->updatedby }}</dd>
            <dt>Created At</dt>
            <dd>{{ $topic->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $topic->updated_at }}</dd>
        </dl>

    </div>
</div>

@endsection