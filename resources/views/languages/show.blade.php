@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Language' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('languages.language.destroy', $language->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('languages.language.index') }}" class="btn btn-primary" title="Show All Language">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('languages.language.create') }}" class="btn btn-success" title="Create New Language">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('languages.language.edit', $language->id ) }}" class="btn btn-primary" title="Edit Language">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Language" onclick="return confirm(&quot;Delete Language??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Language</dt>
            <dd>{{ $language->language }}</dd>

        </dl>

    </div>
</div>

@endsection