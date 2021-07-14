@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
    <div class="add_child_cls">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="inner_add_child text-ar-right editcreatform">
                <h6>@lang('classcourse.edit-courseclass')</h6>
                <form method="POST" action="{{ route('courseclasses.courseclass.update',$courseclass->id) }}" id="createClassForm" name="createClassForm" accept-charset="UTF-8" class="def_form full_def_frm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="row">
                        @include('courseclasses.form', [
                            'courseclass' => $courseclass,
                          ])
                        <div class="col-md-12">
                                {{--  <input name="_method" type="hidden" value="PUT">  --}}
                            <div class="form-group mrgn-bt-30">
                                <a href="{{route('courseclasses.courseclass.myclasses')}}" class="btn btn-primary cancel-btn">@lang('classcourse.cancel')</a>
                                <button type="submit" class="btn btn-primary add_btn" > @lang('classcourse.update') </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/class.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#language_id').select2();
    });
</script>

@endpush