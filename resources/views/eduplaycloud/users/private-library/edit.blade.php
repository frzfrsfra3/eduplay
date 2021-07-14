@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
    <div class="add_child_cls">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="inner_add_child text-ar-right">
                <h6>@lang('exerciseset_form.edit_exercise')</h6>
                <form method="POST" action="{{ route('exercisesets.exerciseset.update', $exerciseset->id) }}" id="edit_exerciseset_form" name="edit_exerciseset_form" accept-charset="UTF-8" class="def_form full_def_frm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="row">
                        @include('eduplaycloud.users.private-library.form', [
                            'exerciseset' => $exerciseset,
                          ])
                        <div class="col-md-12">
                                <input name="_method" type="hidden" value="PUT">
                            <div class="form-group mrgn-bt-30 mrgn-tp-30">
                                <a href="{{route('exercisesets.exerciseset.private')}}" class="btn btn-primary cancel-btn">@lang('exerciseset_form.cancel')</a>
                                <button type="submit" class="btn btn-primary add_btn"> @lang('exerciseset_form.next') </button>
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
@push('inc_jquery')
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#language_id').select2();
    });
</script>
@endpush