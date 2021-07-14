@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="mrgn-tp-30 text-ar-right">

                    @include('disciplines.curriculum_breadcrumb',$discipline)

                    <div class="tbs_of_report tbs_of_report-as">
                            <ul class="tabs_menu tabs_curiiculumn nav">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('explore.discipline.summary',$discipline->id) }}">@lang('disciplines.summary')</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('explore.discipline.published',$discipline->id)}}">@lang('disciplines.latest_published_version')</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('explore.discipline.draft',$discipline->id) }}">@lang('disciplines.latest_draft')</a></li>
                            </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="main_summery_earth">
                    <div class="earth_publish mrgn-bt-10">
                        <div class="name_list float-left">
                            <h4>{{ $discipline->discipline_name }}</h4>
                        </div>
                        <div class="publist_list float-right">
                            <a href="#" class="publish_class_btn">@lang('disciplines.publish_latest_draft')</a>
                            <a href="#" class="edit_btn"></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                           <div class="inner_summery">
                               <h3>@lang('disciplines.summary')</h3>
                               <ul class="excersie_list">
                                   <li>@lang('disciplines.exercise_set'): <span>{{@$discipline->exercisesets()->count()}}</span></li>
                                   <li>@lang('disciplines.classes') : <span>{{@$discipline->courseclasses()->count()}}</span></li>
                               </ul>
                               <ul class="prfl_collabotr">
                                   <li><img src="{{ asset('assets/eduplaycloud/image/co_pr2.png') }}"></li>
                                   <li><img src="{{ asset('assets/eduplaycloud/image/co_pr3.png') }}"></li>
                                   <li><img src="{{ asset('assets/eduplaycloud/image/co_pr4.png') }}"></li>
                                   <li><img src="{{ asset('assets/eduplaycloud/image/co_pr5.png') }}"></li>
                                   <li class="user_counter"><span>112</span></li>
                               </ul>
                           </div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                          <div class="discription_block">
                              <h4>@lang('disciplines.description')</h4>
                              <p>{!! $discipline->description !!}</p>
                          </div>
                        </div>
                    </div>
                        @include("disciplines.versions",$discipline)
                        @include("disciplines.collabratores",$discipline)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!---End Content-->
@endsection