@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @include('eduplaycloud.explore.explore_header')
            <div class="cirriculm_main pad_lfsd_15">
                <div class="main_detail_fltr">
                    <div class="title_with_shrtby">
                        <div class="float-sm-left filtr_with_titile">
                        <h4 class="exersc_title">@lang('filter.curriculum')</h4>
                            @Auth
                            <a href="{{route('explore.curriculum.create')}}" class="creat_new m3">@lang('disciplines.request_new')</a>
                            @endAuth
                            <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                        </div>
                        <div class="float-sm-right short_by text-right">
                            <div class="short_by_select">
                                <label> @lang('filter.sort_by_title') : </label>
                                <select class="selectpicker" id="filter-heading">
                                  <option value="Name">@lang('filter.name')</option>
                                  <option value="Language">@lang('filter.language')</option>
                                  <option value="Topic">@lang('filter.topic')</option>
                                  <option value="Number Of Exercise set">@lang('filter.number_of_exercise_set')</option>
                                  <option value="Number Of Classes">@lang('filter.number_of_classes')</option>
                                </select>
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
                                    <li>
                                        <div class="section_cls">
                                            <h3>@lang('filter.topic')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="topic-operator">
                                                            <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                            <option value="=">=</option>
                                                            <option value="like">@lang('filter.like')</option>
                                                            {{-- <option value="na">@lang('filter.n/a')</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="topic-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="topic-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="section_cls">
                                            <h3>@lang('filter.number_of_exercise_set')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="exercisesets-operator">
                                                            <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                            <option value="="> = </option>
                                                            <option value="<"> < </option>
                                                            <option value=">"> > </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="exercisesets-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="exercisesets-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="section_cls">
                                            <h3>@lang('filter.number_of_classes')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="classes-operator">
                                                            <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                            <option value="="> = </option>
                                                            <option value="<"> < </option>
                                                            <option value=">"> > </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="classes-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="classes-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mrgn-tp-20" id="curriculum">
                    @include ('disciplines.oneelement' )
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---End Content-->

<!--okay_model-->
<div class="modal fade default_modal wht_bg_mdl" id="okay_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('disciplines.thank_you')</h3>
                            <p class="enter_youremil">@lang('disciplines.request_submit')</p>
                            <form class="def_form">
                                <div class="form-group">
                                    <button type="button" data-dismiss="modal" class="btn btn-primary btn-login drk_bg_btn">@lang('disciplines.okay')</button>
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
{{-- <script src="/js/jquery.jscroll.min.js"></script> --}}
<script>
    $(window).bind("pageshow", function() { // update hidden input field $('#formid')[0].reset(); });
        $("#sort-by").val(0).selectpicker("refresh");
    });
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
<script>
    function requestDiscipline(disId) {
        $.ajax({
            url: "{{route('disciplinecollaborators.disciplinecollaborator.requestdiscipline')}}",
            type: 'get',
            data: {'disId':disId},
            success: function (data) {
                // alert(data);
                $('#okay_mdl').on('hide', function() {
                    window.location.reload();
                });
            }

        });
    }

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

      // Filter Data form submit by apply button.
      function filterFormSubmit(){

        $('.main_loader').show();

        var form = $('#filter-form').serialize();

        $.ajax({
            type: "GET",
            url: site_url + '/explore/disciplines/filter',
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