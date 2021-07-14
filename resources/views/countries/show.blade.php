@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Country' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('countries.country.destroy', $country->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="Show All Country">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('countries.country.create') }}" class="btn btn-success" title="Create New Country">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('countries.country.edit', $country->id ) }}" class="btn btn-primary" title="Edit Country">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Country" onclick="return confirm(&quot;Delete Country??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Country Name</dt>
            <dd>{{ $country->country_name }}</dd>
            <dt>Abbreviation Code</dt>
            <dd>{{ $country->abbreviation_code }}</dd>
            <dt>Country Flag</dt>
            <dd>{{ $country->country_flag }}</dd>
            <dt>Created At</dt>
            <dd>{{ $country->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $country->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection