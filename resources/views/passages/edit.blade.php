@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">

@endsection



@section('top')

    @include('myexercisesnavigation' ,[$ispublic=0 ,$exerciseset =$passage->exerciseset])


@endsection

@section('content')

    <div class="panel panel-default">


        <div class="container" >




            <div class="exerciseset-form" id="exerciseset-form" style="margin-bottom: 20px">
            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-8 header-title" >Edit Passage :</div>
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('passages.passage.update', $passage->id) }}"
                  id="edit_passage_form" name="edit_passage_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}

            <input name="_method" type="hidden" value="PUT">
                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" style="text-align: right">
                    <a href="{{ route('passages.passage.index' ,[$passage->exercise_id]) }}" class="btn btn-primary" title="Show All Passage">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('passages.passage.create' ,[$passage->exercise_id]) }}" class="btn btn-success" title="Create New Passage">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <input class="btn btn-edubtn" type="submit" value="Update">

                </div>
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
            @include ('passages.form', [
                                        'passage' => $passage,
                                      ])
                </div>

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