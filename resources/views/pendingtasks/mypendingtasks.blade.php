@extends('authenticated.layouts.default')

@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn text-ar-right">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="my_private_libray">
					<div class="tbs_of_report tbs_of_report-as mrgn-bt-50">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('messages.my_assignment')
							<span class="caret"></span></button>
							@include('eduplaycloud.users.private-library.menu')
						</div>
					</div>
                    <div class="clearfix"></div>
                    {{--  <div class="row">
                        <div class="col-sm-7">
                            <h4 class="exersc_title">@lang('messages.my_tasks')</h4>
                        </div>
                    </div>  --}}

                    {{--  Filter code started  --}}
                    <div class="main_detail_fltr pad_lfsd_20">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="exersc_title">@lang('messages.my_tasks')</h4>
                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            <div class="float-sm-right short_by text-right">
                                <div class="short_by_select">
                                    <label>@lang('filter.sort_by') : </label>
                                    <select class="selectpicker" id="filter-heading">
                                      <option value="description">@lang('filter.description')</option>
                                      <option value="sender">@lang('filter.sender')</option>                                     
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
                                                <h3>@lang('filter.description')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="description-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=" >@lang('filter.equal')</option>
                                                                <option value="like">@lang('filter.contains')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="description-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.sender')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="sender-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                                <option value="na">@lang('filter.n/a')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="sender-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="sender-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.status')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="status-name">
                                                                <option value="pending"  selected>@lang('filter.pending')</option>
                                                                <option value="done" >@lang('filter.done')</option>                                                                            
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button id="status-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>    
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.create_date')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" class="form-control" placeholder="@lang('filter.start_date')" name="createDate" id="startDate">
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
                    {{--  Filter code end  --}}

                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok"></span>
                            {!! session('success_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{--  Task code started   --}}
                    <div class="pad_lfsd_20 mrgn-bt-45" id="filter-pending_task">
                        @include('pendingtasks.filter-pendingtask')
                    </div>
                   
                    {{--  Task code ended   --}}
				</div>
			</div>
		</div>
	</div>
</div>
<!---End Content-->

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/my-task-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });

    $(function () {
        $('#startDate').datetimepicker({
            format: 'DD-MM-YYYY',
            maxDate: 'now',
            /*debug: true*/
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