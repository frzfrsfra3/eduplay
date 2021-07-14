@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Skillcategory' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('skillcategories.skillcategory.destroy', $skillcategory->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('skillcategories.skillcategory.index') }}" class="btn btn-primary" title="Show All Skillcategory">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('skillcategories.skillcategory.create') }}" class="btn btn-success" title="Create New Skillcategory">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('skillcategories.skillcategory.edit', $skillcategory->id ) }}" class="btn btn-primary" title="Edit Skillcategory">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Skillcategory" onclick="return confirm(&quot;Delete Skillcategory??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Discipline</dt>
            <dd>{{ optional($skillcategory->discipline)->discipline_name }}</dd>
            <dt>Skill Category Name</dt>
            <dd>{{ $skillcategory->skill_category_name }}</dd>
            <dt>Skill Category Decsription</dt>
            <dd>{{ $skillcategory->skill_category_decsription }}</dd>
            <dt>Version</dt>
            <dd>{{ $skillcategory->version }}</dd>
            <dt>Sort Order</dt>
            <dd>{{ $skillcategory->sort_order }}</dd>
            <dt>Approve Status</dt>
            <dd>{{ $skillcategory->approve_status }}</dd>
            <dt>Publish Status</dt>
            <dd>{{ $skillcategory->publish_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $skillcategory->createdby }}</dd>
            <dt>Updatedby</dt>
            <dd>{{ $skillcategory->updatedby }}</dd>
            <dt>Created At</dt>
            <dd>{{ $skillcategory->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $skillcategory->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection