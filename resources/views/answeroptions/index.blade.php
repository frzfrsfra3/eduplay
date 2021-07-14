@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
@endsection
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ trans('answeroptions.model_plural') }}</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('answeroptions.answeroption.create') }}" class="btn btn-success" title="{{ trans('answeroptions.create') }}">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($answeroptions) == 0)
            <div class="panel-body text-center">
                <h4>{{ trans('answeroptions.none_available') }}</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>{{ trans('answeroptions.question_id') }}</th>
                            <th>{{ trans('answeroptions.answer_type') }}</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($answeroptions as $answeroption)
                        <tr>
                            <td>{{ optional($answeroption->question)->id }}</td>
                            <td>{{ $answeroption->answer_type }}</td>

                            <td>

                                <form method="POST" action="{!! route('answeroptions.answeroption.destroy', $answeroption->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('answeroptions.answeroption.show', $answeroption->id ) }}" class="btn btn-info" title="{{ trans('answeroptions.show') }}">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('answeroptions.answeroption.edit', $answeroption->id ) }}" class="btn btn-primary" title="{{ trans('answeroptions.edit') }}">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="{{ trans('answeroptions.delete') }}" onclick="return confirm('{{ trans('answeroptions.confirm_delete') }}')">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $answeroptions->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection