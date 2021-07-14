@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
        <div class="add_child_cls">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="inner_add_child circulm_exersice text-ar-right mrgn-bt-50">
                        <h6>@if($type == 'Edit') {{ Lang::get('exercisesets.Edit') }}@endif @lang('exercisesets.exercise_set')   </h6>
                            <div class="main_detail_fltr">
                                <div class="title_with_shrtby">
                                    <div class="float-sm-left filtr_with_titile">
                                    <h4 class="exersc_title">{{ $type == 'Edit' ? Lang::get('exercisesets.Please_select_curriculum_click_update') : Lang::get('exercisesets.select_curriculum') }}</h4>
                                        <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                    </div>
                                    <div class="float-sm-right short_by text-right">
                                        <div class="short_by_select">
                                            <select class="selectpicker" id="filter-heading">
                                              <option value="Name">@lang('filter.name')</option>
                                            </select>
                                            <label>@lang('filter.sort_by_title') :</label>
                                            <select class="selectpicker" id="sort-by">
                                                <option value="Ascending">@lang('filter.ascending')</option>
                                                <option value="Descending">@lang('filter.descending')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="list_of_filter collapse" id="collapseExample">
                                    <div class="card card-body">
                                    <!--Filter Form Apply-->
                                    <form id="filter-form" method="GET">
                                        <input id="base_path" type="hidden" value="{{url('/')}}">
                                        <input type="hidden" name="exercise_id" value="{{$id}}">
                                        <input type="hidden" name="Language_search" value="{{$language_id}}">
                                        <input type="hidden" name="ispublic" value="{{$ispublic}}">
                                        <input type="hidden" name="topic_id" value="{{$topicId}}">
                                        <div class="mani_menu_list">
                                            <div class="float-left">
                                                <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                <ul class="studnt_list_nm" id="fltered-text-list">
                                                  <!--Filter text append here-->
                                                </ul>
                                            </div>
                                            <div class="float-right clear_all_cls">
                                                <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                            </div>
                                        </div>
                                    </form>
                                    <!--End filer form-->
                                        <div class="slct_drop_box">
                                            <ul class="demo-accordion accordionjs " data-active-index="false">
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>@lang('filter.title')</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form  class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <select class="selectpicker" id="name-operator">
                                                                        <option value="0">@lang('filter.select_operator')</option>
                                                                        <option value="=" >@lang('filter.equal')</option>
                                                                        <option value="like">@lang('filter.contains')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" id="name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <button id="name-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12 mrgn-tp-0 mrgn-bt-20">
                                <a href="{{ route('exercisesets.exerciseset.edit',[$id]) }}" class="btn btn-primary cancel-btn cncle-prfct">@lang('select_curriculum.back')</a>
                            <button type="button" data-toggle="modal" data-target="#create_exersis" data-dismiss="modal" class="btn btn-primary add_btn add-prfct create-grade create-button" {{ count($disciplines) == 0 ? 'disabled' : '' }}>{{ $type == 'Edit' ? Lang::get('exercisesets.update') : Lang::get('exercisesets.create')  }}</button>
                                    <a href="{{ route('exercisesets.exerciseset.show',['exerciseset' => $id ,'ispublic' => $ispublic, 'type' => $type]) }}" class="skip_cls">@lang('select_curriculum.skip')</a>
                            </div>
                        </div>
                            <!--Select curriculum and filtered result display here-->
                            <div class="row" id="curriculum">
                                @if(count($disciplines))
                                    @foreach ($disciplines as $discipline)
                                    <div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
                                        <div class="inr_cir_exrs">
                                            <div class="circullm_box circullm_box_btm">
                                                <div class="combo_check_txt">
                                                    <div class="creat_exr orng_checkbx float-left">
                                                        <div class="radio_bx rdio rdio-primary">
                                                            <input name="discipline_name" value="{{ $discipline->id }}" id="discipline_name_{{$discipline->id}}" type="radio" class="custom-control-input radio" {{ (!empty($exerciseset) ? ($exerciseset->discipline_id === $discipline->id ? "checked" : "")  : "")  }}>
                                                            <label class="custom-control-label discipline-name" for="discipline_name_{{$discipline->id}}" data-discipline="{{ $discipline->id }}">{{$discipline->discipline_name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text_block_cir">
                                                    <p>{{ str_limit($discipline->description,'75') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else 
                                <div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
                                    <div class="inr_cir_exrs">
                                        <p>@lang('select_curriculum.no_curriculum')</p>
                                    </div>
                                </div>    
                                @endif
                            </div>
                        <div class="row">
                            <div class="col-md-12 mrgn-tp-30 aaa">
                                <a href="{{ route('exercisesets.exerciseset.edit',[$id]) }}" class="btn btn-primary cancel-btn cncle-prfct">@lang('select_curriculum.back')</a>
                                <button type="button" data-toggle="modal" data-target="#create_exersis" data-dismiss="modal" class="btn btn-primary add_btn add-prfct create-button" {{ count($disciplines) == 0 ? 'disabled' : '' }}>{{ $type == 'Edit' ? Lang::get('exercisesets.update') : Lang::get('exercisesets.create')  }}</button>
                                <a href="{{ route('exercisesets.exerciseset.show',['exerciseset' => $id ,'ispublic' => $ispublic, 'type' => $type]) }}" class="skip_cls">@lang('select_curriculum.skip')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Create-exercise-->
<div class="modal fade default_modal wht_bg_mdl" id="create_exersis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <form class="def_form" action="{{ route('exercisesets.exerciseset.grade') }}" method="POST">
                            <h3>@lang('select_curriculum.select_grade')</h3>
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <div class="df-select">
                                    <input type="hidden" name="exercise_id" value="{{$id}}">
                                    <input type="hidden" name="ispublic" value="{{$ispublic}}">
                                    <input type="hidden" name="type" value="{{$type}}">
                                    <input type="hidden" name="discipline_id" value="{{ (!empty($exerciseset) ? $exerciseset->discipline_id : "") }}" id="modal-discipline-name">
                                        <select name="grade_id" class="selectpicker">
                                            <option disabled selected>@lang('select_curriculum.select_grade')</option>
                                            @if(count($disciplines))
                                                @if(isset($discipline->curriculum_gradelist->grades))
                                                    @foreach ($discipline->curriculum_gradelist->grades as $grade)      
                                                    <option value="{{$grade->id}}" {{ ( $exerciseset->grade_id === $grade->id ? "selected" : "") }}>{{ $grade->grade_name}}</option>
                                                    @endforeach
                                                @endif
                                            @else 
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group publis_mrgn">
                                    {{-- <a href="exercise_set_create.html" class="btn btn-primary btn-login">Done</a> --}}
                                    <button type="submit" class="btn btn-primary btn-login">@lang('select_curriculum.done')</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/select-curriculum.js') }}"></script>
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();

        $('#select-curriculum').each(function(){
            if($(this).find('input[type="radio"]:checked').length > 0)
            {
                $('.create-button').prop('disabled', false);
            }
            else
            {
                //Create button Toggle.
                $('.create-button').prop('disabled', true);
            }    
        });


        //Check discipline name is select or not. 
        $('.discipline-name').on('click',function(){            
                var id = $(this).attr('for');
                var isChecked = $(id).is(":checked");
                $('#modal-discipline-name').val($(this).attr('data-discipline'))
            
                if (isChecked) {
                    $('.create-button').prop('disabled', true);
                } else {
                    $('.create-button').prop('disabled', false);
                }     
            
        })

    });


      // Filter Data form submit by apply button.
      function filterFormSubmit(){

        $('.main_loader').show();

        var form = $('#filter-form').serialize();
        
        $.ajax({
            type: "GET",
            url: site_url + '/exercisesets/select-curriculum/filter',
            data: form, 
            success: function( response ) {
                // console.log(response);
                $('#curriculum').empty();  
                $('#curriculum').html(response);
                $('.main_loader').hide();        
            }
        });
    }
</script>


@endpush