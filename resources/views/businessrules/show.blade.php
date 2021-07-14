@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Businessrule' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('businessrules.businessrule.destroy', $businessrule->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('businessrules.businessrule.index') }}" class="btn btn-primary" title="Show All Businessrule">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('businessrules.businessrule.create') }}" class="btn btn-success" title="Create New Businessrule">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('businessrules.businessrule.edit', $businessrule->id ) }}" class="btn btn-primary" title="Edit Businessrule">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Businessrule" onclick="return confirm(&quot;Delete Businessrule??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Businessrule Name</dt>
            <dd>{{ $businessrule->businessrule_name }}</dd>
            <dt>Businessrule Condition</dt>
            <dd>{{ $businessrule->businessrule_condition }}</dd>
            <dt>Isactive</dt>
            <dd>{{ ($businessrule->isactive) ? 'Yes' : 'No' }}</dd>
            <dt>Created At</dt>
            <dd>{{ $businessrule->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $businessrule->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection