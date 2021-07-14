@extends('authenticated.layouts.default')
@section('content')
@push('inc_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="content_tabs_iner mrgn-tp-30 text-ar-right">
                <div class="main_detail_fltr">
                    <div class="title_with_shrtby">
                        <div class="float-sm-left filtr_with_titile">
                        <h4 class="exersc_title">@lang('filter.curriculum')</h4>
                            <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                        </div>
                        <div class="float-sm-right short_by text-right">
                            <div class="short_by_select">
                                <label>@lang('filter.sort_by_title'):</label>
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
                                            <h3>@lang('filter.name')</h3>
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
                                    <li>
                                        <div class="section_cls">
                                            <h3>@lang('filter.language')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="language-name">
                                                            <option value="0" selected disabled>@lang('filter.select_language')</option>
                                                            @foreach ($languages as $language)
                                                                <option value="{{$language->id}}"> {{$language->language}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button id="language-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="currricm_text">@lang('disciplines.create_new_curriculum')</p>
                 <!--Select curriculum and filtered result display here-->
                 <div class="row" id="curriculum">
                        @include ('disciplines.create-filter-curriculum' )
                </div>
                <div class="row">
                    <div class="col-md-12 mrgn-tp-30">
                        <a href="{{route('explore')}}" class="btn btn-primary cancel-btn cncle-prfct">@lang('disciplines.cancel')</a>
                        <button type="button" data-toggle="modal" data-target="#curri_btn" data-dismiss="modal" class="btn btn-primary add_btn add-prfct">@lang('disciplines.create')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!--Curriculum Details-->
<div class="modal fade default_modal wht_bg_mdl" id="curri_btn" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('disciplines.curriculum_details')</h3>
                                <form class="def_form" id="create_curriculum_form" action="{{route('explore.curriculum.store')}}" method="POST">
                                    @csrf
                                    <div class="form-group mrgn-bt-30">
                                        <label>@lang('disciplines.disciplines_name')</label>
                                        <div class="questn_circl">
                                            <span title="@lang('disciplines.name_of_curriculum')" style="cursor:pointer;">
                                            <i class="fa fa-question-circle-o"></i>
                                            </span>
                                            <input type="text"  name="discipline_name" id="discipline_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('disciplines.description')</label>
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                    <div class="form-group mrgn-bt-30">
                                        <div class="df-select">
                                            <label>@lang('disciplines.select_topic_name')</label>
                                            <select class="selectpicker" name="topic_id" id="topic_id">
                                                @foreach($topics as $topic)
                                                <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mrgn-bt-30">
                                        <div class="df-select">
                                            <label>@lang('disciplines.select_language_preference')</label>
                                            <select class="selectpicker" name="language_preference_id" id="language_preference_id">
                                                @foreach($languages as $language)
                                                <option value="{{$language->id}}">{{$language->language}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mrgn-tp-40">
                                        <button type="submit" id="curriculum_send" class="btn btn-primary btn-login drk_bg_btn">@lang('disciplines.send')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--okay_model-->
<div class="modal fade default_modal wht_bg_mdl" id="curriculum_okay_mdl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('disciplines.thank_you')</h3>
                                <p class="enter_youremil">@lang('disciplines.request_submit')</p>
                                <form class="def_form">
                                    <div class="form-group">
                                        <a href="{{route('explore')}}" class="btn btn-primary btn-login drk_bg_btn">@lang('disciplines.okay')</a>
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
    });

    // Filter Data form submit by apply button.
    function filterFormSubmit(){

    $('.main_loader').show();

    var form = $('#filter-form').serialize();

    $.ajax({
            type: "GET",
            url: site_url + '/explore/discipline/create',
            data: form, 
            success: function( response ) {
                // console.log(response);
                $('#curriculum').empty();  
                $('#curriculum').html(response);
                $('.main_loader').hide();        
            }
        });
    }

    //Submit create curriculum form.
    $('#curriculum_send').on('click',function(){

        $('#create_curriculum_form').validate({

            rules: {
                discipline_name: {
                    required: true,
                    maxlength: 30
                },
                description: {
                    required: true,
                    maxlength: 500
                },
                topic_id: {
                    required: true,
                },
                language_preference_id: {
                    required: true,
                },
            },
            messages: {
              
            },

            submitHandler: function(form) {
                $('#curri_btn').modal('hide');
                $.ajax({
                    url: form.action,
                    type: form.method,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: $(form).serialize(),
                    success: function(response) {
                        $('#curriculum_okay_mdl').modal('show');
                        console.log(response);     
                    }            
                });
            }
            });
    });


    //Check discipline name is select or not. 
    $('.discipline-name').on('click',function(){
        var discipline_id = $(this).attr('data-discipline');
        $.ajax({
            url: site_url + '/explore/one/discipline',
            type: 'GET',
            data: { 'discipline_id' : discipline_id},
            success: function(discipline) {
                $('#discipline_name').val(discipline.discipline_name)
                $('#description').val(discipline.description)
                $('#topic_id').val(discipline.topic_id);
                $('#language_preference_id').val(discipline.language_preference_id);
                $('.selectpicker').selectpicker('refresh')
            }            
        });
                
        
    })
</script>
@endpush