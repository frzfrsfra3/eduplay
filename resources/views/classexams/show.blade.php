@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Classexam' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('classexams.classexam.destroy', $classexam->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('classexams.classexam.index') }}" class="btn btn-primary" title="Show All Classexam">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('classexams.classexam.create') }}" class="btn btn-success" title="Create New Classexam">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('classexams.classexam.edit', $classexam->id ) }}" class="btn btn-primary" title="Edit Classexam">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Classexam" onclick="return confirm(&quot;Delete Classexam??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Class</dt>
            <dd>{{ optional($classexam->courseclass)->id }}</dd>
            <dt>Exam</dt>
            <dd>{{ optional($classexam->exam)->id }}</dd>
            <dt>Addedon</dt>
            <dd>{{ $classexam->addedon }}</dd>

        </dl>

    </div>
</div>

@endsection