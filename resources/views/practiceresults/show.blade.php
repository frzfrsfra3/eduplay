@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Practiceresult' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('practiceresults.practiceresult.destroy', $practiceresult->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('practiceresults.practiceresult.index') }}" class="btn btn-primary" title="Show All Practiceresult">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('practiceresults.practiceresult.create') }}" class="btn btn-success" title="Create New Practiceresult">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('practiceresults.practiceresult.edit', $practiceresult->id ) }}" class="btn btn-primary" title="Edit Practiceresult">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Practiceresult" onclick="return confirm('Delete Practiceresult?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Question</dt>
            <dd>{{ optional($practiceresult->question)->param }}</dd>
            <dt>Answeroption</dt>
            <dd>{{ optional($practiceresult->answeroption)->answer_type }}</dd>
            <dt>Iscorrect</dt>
            <dd>{{ ($practiceresult->iscorrect) ? 'Yes' : 'No' }}</dd>
            <dt>Topics</dt>
            <dd>{{ optional($practiceresult->topic)->topic_name }}</dd>
            <dt>Exercise</dt>
            <dd>{{ optional($practiceresult->exercise)->id }}</dd>
            <dt>Created At</dt>
            <dd>{{ $practiceresult->created_at }}</dd>

        </dl>

    </div>
</div>

@endsection