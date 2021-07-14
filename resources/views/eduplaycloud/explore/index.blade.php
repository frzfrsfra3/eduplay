@extends('authenticated.layouts.default')
@section('content')

<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
               @include('eduplaycloud.explore.explore_header')
                <div class="tp_tab_cntnt tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-displin" role="tabpanel" aria-labelledby="pills-displin-tab">
                        <div class="disciplines_main">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h4 class="exersc_title">@lang('disciplines.disciplines')</h4>
                                    <a href="javascript:;" class="creat_new" data-toggle="modal" data-target="#New_Disciplines" data-dismiss="modal">@lang('disciplines.request_new')</a>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <div class="short_by">
                                        <div class="short_by_select nw_algn">
                                            <label>@lang('filter.sort_by'):</label>
                                            <select class="selectpicker">
                                                <option>@lang('filter.newest')</option>
                                                <option>@lang('filter.newest1')</option>
                                                <option>@lang('filter.newest2')</option>
                                            </select>
                                        </div>
                                        <div class="filter">
                                            <div class="cstm-drpdwn">
                                                <span class="flr-i">@lang('filter.filters')</span>
                                            </div>
                                            <div class="slct_drop_box">
                                                <ul class="demo-accordion accordionjs " data-active-index="false">
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.name')</h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.description') </h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.discipline') </h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.language_pack')</h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </div>
                                        </div>
                                        <div class="clear_all_cls">
                                            <a href="javascript:;" class="clear_all_btn">@lang('filter.clear_all')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (count($disciplines) == 0)
                            <div class="panel-body text-center">
                                <h4>@lang('disciplines.no_di_cu_available')</h4>
                            </div>
                            @else
                            <div class="row dscpln_list">
                                @foreach($disciplines as $discipline)
                                <div class="col-sm-6 col-lg-3">
                                    <div class="discipline_bx">
                                        <a href="javascript:;" class="dcpln_a" data-toggle="modal" data-target="#Maths_Modal" data-dismiss="modal">
                                            @if (strlen($discipline->iconurl) != 0 && File::exists(public_path()."/assets/images/".$discipline->iconurl))
                                                <img src={{ asset('assets/images/'.$discipline->iconurl) }} alt="{{ $discipline->discipline_name }}">
                                            @else
                                                <img src={{ asset('assets/images/displine_default-test.jpg') }} alt="{{ $discipline->discipline_name }}">
                                            @endif
                                            <h5>{{ $discipline->discipline_name }}</h5>
                                            <ul class="bl_or_txt">
                                                @php
                                                    $nbr_of_exercisesets = ($discipline->exercisesets()->count());
                                                    $nbr_of_classes = ($discipline->courseclasses()->count());
                                                @endphp
                                                <li>@lang("explore.curriculum"): {{ $nbr_of_classes }}</li>
                                                <li class="orng_li">@lang('disciplines.exercise_set'): {{ $nbr_of_exercisesets }}</li>
                                            </ul>
                                        </a>
                                        <button class="stngs_btn hvr-push"></button>
                                        <button class="strs_btn hvr-push"></button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="clearfix"></div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-Curriculun" role="tabpanel" aria-labelledby="pills-Curriculun-tab"></div>
                    <div class="tab-pane fade" id="pills-Libray" role="tabpanel" aria-labelledby="pills-Libray-tab">
                        <div class="my_exercise mrgn-tp-50 mrgn-bt-30">
                            <div class="main_detail_fltr">
                                <div class="title_with_shrtby">
                                    <div class="float-sm-left filtr_with_titile">
                                        <h4 class="exersc_title">@lang('disciplines.exercises_set')</h4>
                                        <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                    </div>
                                    <div class="float-sm-right short_by text-right">
                                        <div class="short_by_select">
                                            <label>@lang('filter.sort_by'):</label>
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
                                                        <h3>@lang('filter.title') </h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <select class="selectpicker" id="title-operator">
                                                                        <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                        <option value="=" >@lang('filter.equal')</option>
                                                                        <option value="like">@lang('filter.like')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" id="title-name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>@lang('filter.price')</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form  class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <select class="selectpicker" id="price-operator">
                                                                        <option value="0" selected disabled>@lang('select_operator')</option>
                                                                        <option value="="> = </option>
                                                                        <option value=">"> > </option>
                                                                        <option value="<"> < </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" id="price-name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <button id="price-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>@lang('filter.curriculum')</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form  class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <select class="selectpicker" id="disicipline-operator">
                                                                        <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                        <option value="=">=</option>
                                                                        <option value="like">@lang('filter.like')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" id="disicipline-name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <button id="disicipline-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>@lang('filter')</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <select class="selectpicker" id="grade-operator">
                                                                        <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                        <option value="=">=</option>
                                                                        <option value="like">@lang('filter.like')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" id="grade-name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <button id="grade-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                               
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>@lang('filter.date')</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <form  class="def_form">
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" class="form-control" placeholder="Start Date" id="startDate">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="df-select">
                                                                    <input type="text" class="form-control" placeholder="End Date" id="endDate">
                                                                </div>
                                                            </div>
                                                            <button id="created-date-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list_of_exercise mrgn-tp-30">
                                <div class="row" id="public_library_result"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-Libray" role="tabpanel" aria-labelledby="pills-Libray-tab"></div>

                    <div class="tab-pane fade" id="pills-classes" role="tabpanel" aria-labelledby="pills-classes-tab"></div>

                    <div class="tab-pane fade" id="pills-games" role="tabpanel" aria-labelledby="pills-games-tab"></div>
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/public-library-filter.js') }}"></script>
<script>
@if(\Request::segment(2) == 'publiclibrary')
    $('#pills-Libray-tab').trigger('click');
    // $('.nav-tabs a[href="#pills-Libray"]').tab('show')
    // $('#pills-Libray-tab').addClass('active');
@endif
</script>
<script>
    // Accordion
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
<script>
    $(function () {
        $('#startDate').datetimepicker({
            format: 'DD-MM-YYYY',
            maxDate: 'now'
        });

        $('#endDate').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: false,
            maxDate: 'now'
        });

        $("#startDate").on("dp.change", function (e) {
            $('#endDate').data("DateTimePicker").minDate(e.date);
        });

        $("#endDate").on("dp.change", function (e) {
            $('#startDate').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
@endpush