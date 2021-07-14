@extends('authenticated.layouts.default')

@section('header_styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
 .text-new-line {white-space: pre-wrap;}
</style>
@endsection

@section('content')
@push('inc_jquery')
{{-- //inclued pug in js --}}
@endpush
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="pdng_60_lft">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('exercisesets.exerciseset.private')}}">@lang('exerciseset_show.my_private_exercise')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $exerciseset->title }}</li>
                    </ol>
                </nav>
                @if(Session::has('success_message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--<br />--}}
                @endif
                 @if(Session::has('unexpected_error'))
                    <div class="alert alert-danger">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('unexpected_error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--<br />--}}
                @endif
                <input type="hidden" id="tab_session" value="{!! session('tab') !!}">

                <div class="simple_ed_cls mrgn-tp-10 mrgn-bt-5">
                    <ul class="tabs_menu summary-tbs nav nav-pills mb-3 mrgn_tbs_less" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('exerciseset_show.summary')</a>
                        </li>
                      @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" id="detail-tab" data-toggle="pill" href="#detail" role="tab" aria-controls="detail" aria-selected="false">@lang('exerciseset_show.details')</a>
                        </li>
                      @else
                        <li class="nav-item">
                          <a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#login_btn">@lang('exerciseset_show.details')</a>
                        </li>
                      @endif
                        {{-- <li class="nav-item">
                            <a class="nav-link " id="simple_editor-tab" data-toggle="pill" href="#simple_editor" role="tab" aria-controls="simple_editor" aria-selected="false">@lang('exerciseset_show.simple_editor')</a>
                        </li>
                        <li class="nav-item" style="display:none;">
                            <a class="nav-link " id="edit_simple_editor-tab" data-toggle="pill" href="#edit_simple_editor" role="tab" aria-controls="edit_simple_editor" aria-selected="false">@lang('exerciseset_show.simple_editor')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="myAssest-tab" href="{{ route('myassets')}}">@lang('exerciseset_show.my_files')</a>
                        </li>
                        --}}
                        {{--  Not In Scope  --}}
                        {{--  <li class="nav-item">
                            <a class="nav-link" id="advance_editor-tab" data-toggle="pill" href="#advance_editor" role="tab" aria-controls="advance_editor" aria-selected="false">@lang('exerciseset_show.advance_editor')</a>
                        </li>  --}}
                    </ul>
                    <div class="tp_tab_cntnt tab-content bbbb" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                            <div class="clearfix"></div>
                            <div class="all_editor_cls summery_private_lib">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="name_list">
                                    <h4>{{ $exerciseset->title }}</h4>
                                    </div>
                                </div>
                                @if(Auth::user() && Auth::user()->id === $exerciseset->createdby)
                                <div class="col-sm-8 text-sm-right text-ar-left">
                                    @if(Auth::user()->id == $exerciseset->createdby)
                                        <a href="javascript:;" id="create_que_btn" class="conver_to_problem">@lang('exerciseset_show.create_questions')</a>
                                        <a href="{{ route('exercisesets.exerciseset.importform',$exerciseset->id) }}" class="conver_to_problem">@lang('exerciseset_form.import_bulk')</a>&nbsp;&nbsp;
                                    @endif
                                    {{--  Not In Scope  --}}
                                    {{--  <a href="#" class="conver_to_problem">@lang('exerciseset_show.import_bulk')</a>  --}}
                                    @if(Auth::user()->id == $exerciseset->createdby)
                                        <a href="{{ route('exercisesets.exerciseset.edit',[$exerciseset->id]) }}" class="edit_btn v_algin_m"></a> 
                                    @endif
                                </div>
                                @endif
                            </div>
                              <div class="row">
                                <div class="col-sm-12">
                                   <div class="discription_block gray_bg_blk">
                                        <h4>@lang('exerciseset_show.description')</h4>
                                        <p>{{ $exerciseset->description }}</p>
                                    </div>
                                </div>
                              </div>
                              <div class="clearfix"></div><br/>
                                <div class="summery_title">
                                    @if(isset($exerciseset->topic_id))
                                    <h3>{{ $exerciseset->topics->topic_name }} </h3>
                                    @endif
                                    {{-- <h3>@lang('exerciseset_show.summary') </h3> --}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-xl-4">
                                        <div class="inner_summery">
                                            <ul class="star_wth_user medium_star_user">
                                                <li>
                                                    <div class="gray_star">
                                                        <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                    </div>
                                                    <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                                                </li>
                                            </ul>
                                            <ul class="excersie_list practice_list blue-clr-ln">
                                                <li>@if ($exerciseset->price != 0)
                                                        ${{ $exerciseset->price }}
                                                    @else
                                                        @lang('exerciseset_show.free')
                                                    @endif
                                                </li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.status') :<span> {{ucfirst($exerciseset->publish_status) }}</span></li> 
                                                <li>@lang('exerciseset_show.updated') :<span>{{$exerciseset->updated_at}} </span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.discipline_curriculum')  :
                                                  <span>
                                                    @if(optional($exerciseset->discipline)->discipline_name !== null) 
                                                      {{ optional($exerciseset->discipline)->discipline_name }}
                                                    @else
                                                      @lang('filter.n/a')
                                                    @endif
                                                  </span>
                                                </li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.discipline')  :<span> {{ optional($exerciseset->topics)->topic_name }} </span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.language') :<span> {{ optional($exerciseset->language)->language }}</span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.total_question') :<span>{{ $exerciseset->question->count() }}</span></li>
                                             </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.total_skill_linked') :<span>{{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}</span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('exerciseset_show.total_duration') :<span>{{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}</span></li>
                                            </ul>
                                              <ul class="excersie_list practice_list">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-xl-8">
                                        <div class="discription_block gray_bg_blk">
                                            {{-- <h4>@lang('exerciseset_show.description')</h4>
                                            <p>{{ $exerciseset->description }}</p> --}}
                                            <div class="skill-table">
                                            <table>
                                              <thead>
                                                <tr>
                                                  <th>@lang('exerciseset_show.curriculum_skill_name')</th>
                                                  <th>@lang('exerciseset_show.linked_questions_count')</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              @if(count($associatedSkills) > 0)
                                                @foreach($associatedSkills as $skillCategories)
                                                  @if(count($skillCategories->skill) > 0)
                                                    @foreach($skillCategories->skill as $skill)
                                                      @if(count($skill->skillQuestion) > 0)
                                                      <tr>
                                                        <td>{{ $skill->skill_name }} </td>
                                                        <td> {{ count($skill->skillQuestion)}} </td>
                                                      </tr>
                                                      @endif
                                                    @endforeach
                                                  @endif
                                                @endforeach
                                                @else
                                                  <tr>
                                                      <td colspan="2">
                                                        @lang("messages.no_skill_available")
                                                      </td>
                                                    </tr>
                                              @endif
                                              </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="review_section">
                                            <div class="row">
                                                <div class="col-md-8 col-xl-11">
                                                    <div class="inner_review_section">
                                                        <h3>@lang('exerciseset_show.reviews_and_ratings')</h3>
                                                        <div class="row">
                                                            <div class="col-lg-5 col-xl-4">
                                                                <ul class="star_wth_user big_star_user">
                                                                    <li>
                                                                        <div class="gray_star">
                                                                            <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                                        </div>
                                                                        <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                                                                    </li>
                                                                </ul>
                                                                <div class="rating_graph mrgn-tp-20">
                                                                    <div class="row_rating">
                                                                        @for($i = 5; $i >= 1; $i--)
                                                                            <div class="rtng_bbx">
                                                                            <div class="side">
                                                                                <div>{{$i}}</div>
                                                                            </div>
                                                                            <div class="middle">
                                                                                <div class="bar-container">
                                                                                    @php $total = 0; 
                                                                                        foreach($userrate as $ratekey => $item) {
                                                                                            if($item->rate == $i)
                                                                                                $total += 1;
                                                                                        }
                                                                                        $avg = 0;
                                                                                        if(count($userrate))
                                                                                            $avg = (@$total) * 100 / count(@$userrate)
                                                                                    @endphp
                                                                                    <div class="bar-{{$i}}" style="width: {{$avg}}%;"></div>
                                                                                </div>
                                                                                <small class="pull-right" style="color:blue;">{{$total}}</small>
                                                                            </div>
                                                                            </div>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-xl-8">
                                                                <div class="rating_view_detail">
                                                                @foreach($userrate as $ratekey => $item)
                                                                    <div class="rew_prfl_sect	in after_{{$ratekey}}">
                                                                        <div class="prfl_img">
                                                                            @if($item->user_image)
                                                                            <img src="{{asset('assets/images/profiles')}}/{{  $item->user_image }}">
                                                                            @else
                                                                            <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
                                                                            @endif
                                                                        </div>
                                                                        <div class="rate_date">
                                                                            <div class="title_star">
                                                                                <h6>{{@$item->user_name}}</h6>
                                                                                <div class="gray_star">
                                                                                    <div class="orng_star" style="width: {{(@$item->rate) * 100 / 5}}%;"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="date_frmt">
                                                                                <span>{{@\Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</span>
                                                                            </div>
                                                                        </div>
                                                                        <p>{{@$item->body}}</p>
                                                                    </div>
                                                                @endforeach
                                                                    <div class="rew_prfl_sectin view_more">
                                                                        <a href="javascript:;" id="view_more_link" class="view_more_btn">@lang('exerciseset_show.view_more')</a>
                                                                        <a href="javascript:;" id="view_less_link" class="view_more_btn" style="display:none;">@lang('exerciseset_show.view_less')</a>
                                                                    </div>
                                                                    {{--  <div class="write_review mrgn-tp-20">
                                                                        <div class="accordion write_accordion" id="accordionExample">
                                                                            <div class="card">
                                                                                <button class="btn btn-link write_rivw_bnt" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                    @lang('exerciseset_show.write_a_review')
                                                                                </button>
                                                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                                    <div class="card-body">
                                                                                        <form class="def_form riew_frm" id="review_form" method="POST">
                                                                                            @csrf
                                                                                            <div class="form-group">
                                                                                                <div class="text-right text-ar-left posted_list">
                                                                                                    <a href="#">@lang('exerciseset_show.posted_as') {{Auth::user()->name}} </a>
                                                                                                    <a href="javascript:;" id="clear_review">@lang('exerciseset_show.clear')</a>
                                                                                                </div>
                                                                                                <input type="hidden" name="id" id="exerciseset_id" value="{{$exerciseset->id}}">
                                                                                                <textarea class="form-control" name="comment" id="comment" placeholder="@lang('exerciseset_show.write_a_review')"></textarea>
                                                                                            </div>
                                                                                            <ul class="star_wth_user">
                                                                                                <li>
                                                                                                    <div id="give_rate"></div>
                                                                                                    <span class="rtng blue-clr">@lang('exerciseset_show.overall_rating')</span>
                                                                                                    <div id="rating_err" style="color: crimson !important;font-size: 14px;">
            
                                                                                                    </div>
                                                                                                </li>
                                                                                            </ul>
                                                                                            <div class="form-group">
                                                                                                <button type="button" class="submit_btn" id="submit_review">@lang('exerciseset_show.submit')</button>
                                                                                                <button type="button" class="cancel-gry-btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">@lang('exerciseset_show.cancel')</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                            <div class="row">
                                <div class="col-md-12">
                                     <!--Filter part-->
                                  <div class="main_detail_fltr">
                                      <div class="title_with_shrtby">
                                          <div class="float-sm-left filtr_with_titile">
                                              <h4 class="simple_editor">@lang('exerciseset_show.details')</h4>
                                              <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                          </div>
                                          <div class="float-sm-right short_by text-right">
                                                  <button type="button" class="btn publish_class_btn m2 m2-mrgn" onclick="questionsCopy()">@lang('exerciseset_show.copy')</button>
                                                  {{-- <button type="button" class="btn publish_class_btn m2 m2-mrgn" onclick="questionsMove()">@lang('exerciseset_show.move')</button> --}}
                                                  {{-- <button type="button" class="btn publish_class_btn m2 m2-mrgn" onclick="linkToSkill()">@lang('exerciseset_show.link_to_skill')</button> --}}
                                             
                                              {{-- <div class="short_by_select">
                                                  <label>@lang('filter.sort_by'):</label>
                                                  <select class="selectpicker" id="sort-by">
                                                      <option value="Ascending">@lang('filter.ascending')</option>
                                                      <option value="Descending">@lang('filter.descending')</option>
                                                  </select>
                                              </div> --}}
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
                                                              <h3>@lang('filter.title')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="details-operator">
                                                                              <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                              {{-- <option value="=" >@lang('filter.equal')</option> --}}
                                                                              <option value="like">@lang('filter.contains')</option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <input type="text" id="details-name" class="form-control">
                                                                      </div>
                                                                  </div>
                                                                  <button id="details-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                      </li>
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.minimum_time')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="min-time-operator">
                                                                              <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                              <option value="="> = </option>
                                                                              <option value=">"> > </option>
                                                                              <option value="<"> < </option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <input type="text" id="min-time-name" class="form-control">
                                                                      </div>
                                                                  </div>
                                                                  <button id="min-time-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                      </li>
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.maximum_time')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="max-time-operator">
                                                                              <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                              <option value="="> = </option>
                                                                              <option value=">"> > </option>
                                                                              <option value="<"> < </option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <input type="text" id="max-time-name" class="form-control">
                                                                      </div>
                                                                  </div>
                                                                  <button id="max-time-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                      </li>
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.difficulty_level')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="difficuly-name">
                                                                              <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                              <option value="easy"> @lang('filter.easy') </option>
                                                                              <option value="medium"> @lang('filter.medium') </option>
                                                                              <option value="hard"> @lang('filter.hard') </option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                
                                                                  <button id="difficuly-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                      </li>
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.skill')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <div  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="skill_category">
                                                                              @if(count($skill_categories))
                                                                                  <option value="0"  selected disabled>@lang('filter.select_skill_categories')</option>
                                                                                  @foreach($skill_categories as $skill_category)
                                                                                      <option value="{{$skill_category->id}}">{{$skill_category->skill_category_name}}</option>
                                                                                  @endforeach
                                                                              @else 
                                                                                  <option value="0"  selected disabled>@lang('filter.no_skill_categories_available')</option>
                                                                              @endif
                                                                          </select>
                                                                      </div>
                                                                      <div class="df-select" id="select_skill_prnt">
                                                                          <select class="selectpicker" id="select_skill">
                                                                              <option value="0"  selected disabled>@lang('filter.select_skill')</option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                
                                                                  <button id="skill-filter-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </div>
                                                          </div>
                                                      </li>
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.tag')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="tags-operator">
                                                                              <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                              <option value="=" >@lang('filter.equal')</option>
                                                                              <option value="like">@lang('filter.contains')</option>
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <input type="text" id="tags-name" class="form-control">
                                                                      </div>
                                                                  </div>
                                                                  <button id="tags-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                      </li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                    <!--End Filter Section-->
                        </div>
                        <input type="hidden" id="exercise_id" value="{{$exerciseset->id}}">
                                <div class="clearfix"></div><br/>
                                <div class="col-md-12" id="questiondiv">
                                
                               	@include('questions.exercise_question')
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Plugins List Modal -->

<!-- Modal -->


<!-- pugin static Modal -->

<!--Copy Question-->
<div class="modal fade default_modal wht_bg_mdl" id="copy_question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exerciseset_show.select_exercisesets')</h3>
                            <form class="def_form" id="copy_form" method="post" action="{{ route('exercise.copy.question') }}">
                            @csrf
                                @if(count($exercisesets) > 0)
                                <div class="form-group">
                                    <div class="df-select">
                                        <select class="selectpicker" name="select_exercisesets" required>
                                            @foreach($exercisesets as $exerciseset)
                                                <option value="{{$exerciseset->id}}">{{$exerciseset->title}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="copyQuestionIds" id="copyQuestionIds" value="">
                                    </div>
                                </div>
                                <div class="form-group publis_mrgn">
                                    <button type="submit" id="copy_submit" class="btn btn-primary btn-login">@lang('exerciseset_show.copy')</button>
                                </div>
                                @else 
                                    <p>Added More exercise</p>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Move Question-->
<div class="modal fade default_modal wht_bg_mdl" id="move_question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exerciseset_show.select_exercisesets')</h3>
                            <form class="def_form" method="post" action="{{ route('exercise.move.question') }}">
                            @csrf
                                @if(count($exercisesets) > 0)
                                <div class="form-group">
                                    <div class="df-select">
                                        <select class="selectpicker" name="select_exercisesets" required>
                                            @foreach($exercisesets as $exerciseset)
                                                <option value="{{$exerciseset->id}}">{{$exerciseset->title}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="moveQuestionIds" id="moveQuestionIds" value="">
                                    </div>
                                </div>
                                <div class="form-group publis_mrgn">
                                    <button type="submit" id="move_submit" class="btn btn-primary btn-login">@lang('exerciseset_show.move')</button>
                                </div>
                                @else 
                                    <p>Added More exercise</p>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user())
<input type="hidden" id="auth_check" value="1">
@else
<input type="hidden" id="auth_check" value="0">
@endif
    
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')<?php /*Load jquery to footer section*/ ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>  
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/question-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
@include('authenticated.includes.render_script')
<script>

        var numItems = 1;
        $(document).ready(function()
        {
            numItems = $('.rew_prfl_sectin').nextUntil('.view_more').length;
            if(numItems >= 3) {
                $('div.after_1').nextUntil('.view_more').hide();
            }
            else {
                $('#view_more_link').hide();
            }
        });

        $('#view_more_link').click(function()
        {
            if(numItems >= 3)
            {
                $('div.after_1').nextAll().show();
                $(this).hide();
                $('#view_less_link').show();
            }
        });

        $('#view_less_link').click(function()
        {
            if(numItems >= 3)
            {
                $('div.after_1').nextUntil('.view_more').hide();
                $(this).hide();
                $('#view_more_link').show();
            }
        });


    //Still hide modal.
    function hideModal(){
        $('#plugin_assets').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }

    // This global varible using for parameter value fetch.
    var finalcsvArray=[];
</script>
<script>
   function showQuePluginList(id) {
       $('#plugin_list_id').modal('show');
   }

    /*accordian*/
    jQuery(document).ready(function($)  {

        $(".demo-accordion").accordionjs();


    });
    $(document).ready(function () {
        if (window.location.hash) {
            var hrf =  $('.summary-tbs a[href="'+window.location.hash+'"]').tab('show');
        } else {
            //var hrf =  $('.summary-tbs a[href="#summary"]').tab('show');
        }
    });
</script>
<script>

@if(Session::has('tab'))
    var tab = $('#tab_session').val();
    $('#pills-tab > li > a[href="#'+tab+'"]').tab('show');
    @php Session::forget('tab') @endphp
@endif


$('#create_que_btn').click(function(e){
    e.preventDefault();
    $('#pills-tab > li > a[href="#simple_editor"]').tab('show');
    // createQuePreview();
});

$('#pills-tab > li > a').click(function(e)
{
    $('.tab-pane').removeClass('active show');

    var tabId = $(this).attr('href');
    $(tabId).addClass('active show');

    if($(this).attr('id') != 'edit_simple_editor-tab') {
        $('#pills-tab > li > a[href="#edit_simple_editor"]').parent('li').hide();
        $('#pills-tab > li > a[href="#simple_editor"]').parent('li').show();
    }
    if($(this).attr('id') == 'simple_editor-tab'){
        // createQuePreview();
        // document.getElementById("simple_editor_form").reset();
    }
});

function editQuestion(id)
{
    var qid = $('#'+id).attr('data-queid');
    // var url = $('#'+id).attr('data-url');
    var url = site_url + '/questions/edit_question/'+qid;
    window.location.href = url;

}



function deleteQuestion(id)
{
    var qid = $('#'+id).attr('data-queid');
    swal({
        title: "@lang('exercisesets.are_you_sure')",
        text: "@lang('exercisesets.once_deleted')",
        icon: "warning",
        buttons: true,
        buttons : [
            '@lang("exerciseset_form.cancel")',
            '@lang("exercisesets.ok")'
        ],
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            $('#'+id).parent('form').submit();
        }
    });
}
var direction = 'ltr';
$(document).ready(function()
{
    // For Language Direction
    @if($exerciseset->language->language == 'Arabic')
        direction = 'rtl';
        $('.priew_body').css({"text-align": "right"});
        $('.priew_body .question_ans').addClass("ar_question_ans");
        $('.priew_body .hint_sec').addClass("ar_hint_sec");
    @endif
    $('.lang-dir').attr('dir', direction);
    // Add Validation Method For Simple Editor
    jQuery.validator.addMethod("videourl", function(value, element) {
        return this.optional(element) || /embed\/([a-zA-Z0-9\-_]+)/.test(value);
    }, "Please specify the correct url");

    var max = "{{config('app.max_file_size')}}";
    jQuery.validator.addMethod("filesize", function(value, element) {
        if(element.files[0].size < 0 || element.files[0].size >= (max * 1000)) {
            return false;
        }
        return true;
    }, "More than 200KB is not acceptable.");
    // --------------------------------------

    var lastPage = $('#last_page').val();
    var lastItem = $('#last_item').val();
    var url = window.location.href;
    var myString = url.substr(url.lastIndexOf("?") + 1);
    var page_no = myString.substr(myString.indexOf("=") + 1);
    if (myString.indexOf('page') > -1)
    {
        if(lastPage == undefined && lastItem == undefined) {
            stripped = url.substring(0, url.indexOf('=') + '='.length);
            document.location.href= stripped+(page_no - 1);
        } else {
            $('#pills-tab > li > a[href="#detail"]').tab('show');
        }
    }
});


//---------Link to Skill Script Start----------------------

//Collect selected Question's id and append to Array.
var QuestionCheckboxValues = [];

$(document).on('click','#question_all_check',function(){
    var allcheck = $('input[name="allquestions"]:checked').length;
    if (allcheck) {
        $('input[name="questions[]"]').prop('checked', this.checked);
    } else {
        $('input[name="questions[]"]').removeAttr('checked');
    }
});


function collectQuestionId(){
    var QuestionChecked = $('input[name="questions[]"]:checked').length;
    if (QuestionChecked) {
        $('input[name="questions[]"]:checked').each(function(index, elem) {
            QuestionCheckboxValues.push($(elem).val());
        });

    } else {
        var errorMessage  = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                            +'<strong>@lang("exercisesets.error")!</strong> @lang("exercisesets.please_select_question_first") !!'
                            +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            +'<span aria-hidden="true">&times;</span>'
                            +'</button>'
                            +'</div>';

        $('#flash_msg').html(errorMessage);
    }
}

//Submit link to skill.
function linkToSkill(){
    collectQuestionId();
    $('#questionsIds').val(QuestionCheckboxValues);
    $('#exerciseId').val($('#exercise_id').val());

    if($('#questionsIds').val() != ''){
        $('#link_to_skill_form').submit();
    }
}

//Question Copy
function questionsCopy(){
    collectQuestionId();
    if($('input[name="questions[]"]:checked').length > 0) {
        $('#copyQuestionIds').val(QuestionCheckboxValues);
        $('#copy_question').modal('show');
    } else {
        $('#copy_question').modal('hide');
     }
}
//Question Move
function questionsMove(){
   collectQuestionId();
    if($('input[name="questions[]"]:checked').length > 0) {
        $('#moveQuestionIds').val(QuestionCheckboxValues);
        $('#move_question').modal('show');
    } else {
        $('#move_question').modal('hide');
     }
}
//---------Link to Skill Script End----------------------
</script>
@endpush
