@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @include('eduplaycloud.explore.explore_header')
                <!--Filter part-->
                <div class="my_exercise mrgn-tp-50 mrgn-bt-30">
                    <div class="main_detail_fltr">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="exersc_title">@lang('filter.games')</h4>
                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            <div class="float-sm-right short_by text-right">
                                <div class="short_by_select">
                                    <label>@lang('filter.sort_by') :</label>
                                    <select class="selectpicker" id="filter-heading">
                                      <option value="Publisher">@lang('filter.publisher')</option>
                                      <option value="Age Range">@lang('filter.age_range')</option>
                                      <option value="Category">@lang('filter.category')</option>
                                      <option value="Operating System">@lang('filter.operating_system')</option>
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
                                <input id="route_name" type="hidden" value="{{Route::current()->getName()}}">
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
                                                <h3>@lang('filter.publisher')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="publisher-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=" >@lang('filter.equal')</option>
                                                                <option value="like">@lang('filter.contains')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="publisher-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="publisher-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.age_range')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="age-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=" >@lang('filter.equal')</option>
                                                                <option value="like">@lang('filter.contains')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="age-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="age-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li> 
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.category')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="category-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=" >@lang('filter.equal')</option>
                                                                <option value="like">@lang('filter.contains')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="category-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="category-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li> 
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.operating_system')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="operating-system">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="android" >@lang('filter.android')</option>
                                                                <option value="IOS">@lang('filter.ios')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button id="operating-system-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.rating')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="rating-name">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="1.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="2.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="3.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="4.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="5.0"></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button id="rating-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>    
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_dashboard mrgn-tp-10 aaa">
                        <div class="list_of_exercise mrgn-tp-20">
                            <div class="row1" id="course-classes">
                                <ul class="games_list" id="games-result">
                                    @include('games.one-game')
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Filter Section-->                  

            </div>
        </div>
    </div>
</div>

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/game-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
@endpush