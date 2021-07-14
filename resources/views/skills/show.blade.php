@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Skill' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('skills.skill.destroy', $skill->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('skills.skill.index') }}" class="btn btn-primary" title="Show All Skill">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('skills.skill.create') }}" class="btn btn-success" title="Create New Skill">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('skills.skill.edit', $skill->id ) }}" class="btn btn-primary" title="Edit Skill">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Skill" onclick="return confirm(&quot;Delete Skill??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Skill Category</dt>
            <dd>{{ optional($skill->skillcategory)->skill_category_name }}</dd>
            <dt>Topic</dt>
            <dd>{{ optional($skill->topic)->id }}</dd>
            <dt>Grade</dt>
            <dd>{{ optional($skill->grade)->grade_name }}</dd>
            <dt>Skill Name</dt>
            <dd>{{ $skill->skill_name }}</dd>
            <dt>Skill Description</dt>
            <dd>{{ $skill->skill_description }}</dd>
            <dt>Version</dt>
            <dd>{{ $skill->version }}</dd>
            <dt>Created At</dt>
            <dd>{{ $skill->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $skill->updated_at }}</dd>
            <dt>Publish Status</dt>
            <dd>{{ $skill->publish_status }}</dd>
            <dt>Approve Status</dt>
            <dd>{{ $skill->approve_status }}</dd>
            <dt>Createdby</dt>
            <dd>{{ $skill->createdby }}</dd>
            <dt>Updated By</dt>
            <dd>{{ $skill->updatedBy }}</dd>
            <dt>Sort Order</dt>
            <dd>{{ $skill->sort_order }}</dd>

        </dl>

    </div>
</div>

@endsection