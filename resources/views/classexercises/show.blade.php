@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Classexercise' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('classexercises.classexercise.destroy', $classexercise->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('classexercises.classexercise.index') }}" class="btn btn-primary" title="Show All Classexercise">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('classexercises.classexercise.create') }}" class="btn btn-success" title="Create New Classexercise">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('classexercises.classexercise.edit', $classexercise->id ) }}" class="btn btn-primary" title="Edit Classexercise">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Classexercise" onclick="return confirm(&quot;Delete Classexercise??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Class</dt>
            <dd>{{ optional($classexercise->courseclass)->id }}</dd>
            <dt>Exercise</dt>
            <dd>{{ optional($classexercise->exercise)->id }}</dd>
            <dt>Addedon</dt>
            <dd>{{ $classexercise->addedon }}</dd>

        </dl>

    </div>
</div>

@endsection