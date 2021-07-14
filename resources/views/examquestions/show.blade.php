@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Examquestion' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('examquestions.examquestion.destroy', $examquestion->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('examquestions.examquestion.index') }}" class="btn btn-primary" title="Show All Examquestion">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('examquestions.examquestion.create') }}" class="btn btn-success" title="Create New Examquestion">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('examquestions.examquestion.edit', $examquestion->id ) }}" class="btn btn-primary" title="Edit Examquestion">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Examquestion" onclick="return confirm(&quot;Delete Examquestion??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Exam</dt>
            <dd>{{ optional($examquestion->exam)->id }}</dd>
            <dt>Question</dt>
            <dd>{{ optional($examquestion->question)->id }}</dd>
            <dt>Sort Order</dt>
            <dd>{{ $examquestion->sort_order }}</dd>

        </dl>

    </div>
</div>

@endsection