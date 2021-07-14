@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
@endsection
@section('content')

    <div class="panel panel-default">
  
        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ !empty($title) ? $title : 'Answeroption' }}</h4>
            </div>
            <div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('answeroptions.answeroption.index') }}" class="btn btn-primary" title="{{ trans('answeroptions.show_all') }}">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('answeroptions.answeroption.create') }}" class="btn btn-success" title="{{ trans('answeroptions.create') }}">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>

            </div>
        </div>

        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('answeroptions.answeroption.update', $answeroption->id) }}" id="edit_answeroption_form" name="edit_answeroption_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('answeroptions.form', [
                                        'answeroption' => $answeroption,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('answeroptions.update') }}">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>tinymce.init({ plugins : ['image','media','table','eqneditor'],toolbar: "image | media | table | eqneditor ",selector : "#details",menubar: false, images_upload_url: 'postAcceptor.php',
            automatic_uploads: false });</script>

@endsection