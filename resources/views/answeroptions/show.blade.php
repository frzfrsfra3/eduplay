@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
@endsection
@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Answeroption' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('answeroptions.answeroption.destroy', $answeroption->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('answeroptions.answeroption.index') }}" class="btn btn-primary" title="{{ trans('answeroptions.show_all') }}">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('answeroptions.answeroption.create') }}" class="btn btn-success" title="{{ trans('answeroptions.create') }}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('answeroptions.answeroption.edit', $answeroption->id ) }}" class="btn btn-primary" title="{{ trans('answeroptions.edit') }}">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('answeroptions.delete') }}" onclick="return confirm('{{ trans('answeroptions.confirm_delete') }}?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ trans('answeroptions.question_id') }}</dt>
            <dd>{{ optional($answeroption->question)->id }}</dd>
            <dt>{{ trans('answeroptions.answer_type') }}</dt>
            <dd>{{ $answeroption->answer_type }}</dd>
            <dt>{{ trans('answeroptions.details') }}</dt>
            <dd>{{ $answeroption->details }}</dd>
            <dt>{{ trans('answeroptions.iscorrect') }}</dt>
            <dd>{{ ($answeroption->iscorrect) ? 'Yes' : 'No' }}</dd>
            <dt>{{ trans('answeroptions.sort_order') }}</dt>
            <dd>{{ $answeroption->sort_order }}</dd>
            <dt>{{ trans('answeroptions.mediapath') }}</dt>
            <dd>{{ $answeroption->mediapath }}</dd>
            <dt>{{ trans('answeroptions.mediaurl') }}</dt>
            <dd>{{ $answeroption->mediaurl }}</dd>

        </dl>

    </div>
</div>

@endsection