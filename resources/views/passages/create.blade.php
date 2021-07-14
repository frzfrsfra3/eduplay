@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">

@endsection


@section('top')

    @include('myexercisesnavigation' ,[$ispublic=0 ])


@endsection

@section('content')

    <div class="panel panel-default">
        <div class="container" >
            <div class="exerciseset-form" id="exerciseset-form" style="margin-bottom: 20px">
                <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-8 header-title" >Create New Passage :</div>
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif




            <form method="POST" action="{{ route('passages.passage.store' ,[$exerciseset->id]) }}" accept-charset="UTF-8" id="create_passage_form" name="create_passage_form" class="form-horizontal">
            {{ csrf_field() }}
                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" style="text-align: right">
                    <a href="{{ route('passages.passage.index' ,[$exerciseset->id]) }}" class="btn btn-edubtn" title="Show All Passage">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <input class="btn btn-edubtn" type="submit" value="Add">


                </div>

            @include ('passages.form', [
                                        'passage' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">

                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>

@endsection
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>tinymce.init({ plugins : ['image','media','table','eqneditor'],toolbar: "image | media | table | eqneditor  | alignleft aligncenter alignright alignjustify | removeformat ",selector : "#passage_text",menubar: false,
        relative_urls: false,
        filemanager_title:"Responsive Filemanager",
        image_advtab: true,
        external_filemanager_path:"{{ asset('assets/filemanager/') }}/",
        external_plugins: { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}" }, });
</script>
@endsection
