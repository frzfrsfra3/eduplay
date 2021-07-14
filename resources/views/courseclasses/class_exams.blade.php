<div class="main_summery_earth pd_lf_25">
        <div class="main_detail_fltr">
                <div class="title_with_shrtby">
                    <div class="name_list float-left mrgn-tp-0">
                        <h4 class="exersc_title">{{ $courseclass->class_name }}</h4>
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
                        <input name="class_id" type="hidden" value="{{$courseclass->id}}">
                        <div class="mani_menu_list">
                            <div class="float-left">
                                <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                <ul class="studnt_list_nm" id="fltered-text-list">
                                  <!--Filter text append here-->
                                </ul>
                            </div>
                            <div class="float-right clear_all_cls">
                                <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang('classcourse.clear_all')</a>
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
                                        <form  class="def_form">
                                            <div class="form-group">
                                                <div class="df-select">
                                                    <select class="selectpicker" id="title-operator">
                                                        <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                        <option value="=" >@lang('filter.equal')</option>
                                                        <option value="like">@lang('filter.contains')</option>
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
                                        <h3>@lang('classcourse.date')</h3>
                                    </div>
                                    <div class="class-detail">
                                        <form  class="def_form">
                                            <div class="form-group">
                                                <div class="df-select">
                                                    <input type="text" class="form-control" placeholder="@lang('filter.start_date')" name="startDate" id="startDate">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="df-select">
                                                    <input type="text" class="form-control" placeholder="@lang('filter.end_date')" name="endDate" id="endDate">
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
        <div class="list_of_exercise add_nw_exrsc mrgn-tp-0">
            <h4 class="exersc_title">@lang('classcourse.assignments')</h4>
            @if(Auth::user()->hasRole('Teacher') && Auth::user()->id ==  $courseclass->teacher_userid)
                <a href="{{ route('courseclasses.courseclass.addexamtoclass',$courseclass->id) }}" class="creat_new pdng_add_btn">@lang('classcourse.Add')</a>
            @endif
            <div class="row" id="assignment-result">
                <!--Filtered result append here from assignment-filter blade-->
            </div>
        </div>
    </div>