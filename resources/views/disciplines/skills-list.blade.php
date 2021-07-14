@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
	<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-11">
			<div class="pdng_60_lft">
				<nav aria-label="tp-breadcm" class="tp-breadcm">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('explore')}}">@lang('filter.curriculum')</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{ $disciplines['discipline_name'] }}</li>
					</ol>
				</nav>
				<div class="main_summery_earth dcspln_inner_main">
          <div class="row">
            {{-- <div class="col-md-12"><h6 class="grd_title"></h6></div> --}}
            <div class="col-md-12 mrgn-bt-30">
                <div class="bd-example bd-example-tabs">
                    <div class="row">
                        <div class="col-md-4 col-xl-3 pdn_rigt_less">
                            <div class="grade_tabs nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                              @foreach($skill_category as $skillCatKey => $skillCategory)
                                <a class="nav-link {{ $skillCatKey == 0 ? 'active show' : '' }}" id="v-pills-spirals-loops-tab{{$skillCatKey}}" data-toggle="pill" href="#v-pills-spirals-loops{{$skillCatKey}}" role="tab" aria-controls="v-pills-spirals-loops{{$skillCatKey}}" aria-selected="false">{{$skillCategory['skill_category_name']}}</a>
                              @endforeach
                            </div>
                        </div>
                        <div class="col-md-8 col-xl-9 pdn_left_less">
                            <div class="tab-content inner_grade_panel" id="v-pills-tabContent">
                             @foreach($skill_category as $skillCatKey => $skillCategory)
                                <div class="tab-pane fade  {{ $skillCatKey == 0 ? 'active show' : '' }}" id="v-pills-spirals-loops{{$skillCatKey}}" role="tabpanel" aria-labelledby="v-pills-spirals-loops-tab{{$skillCatKey}}">
                                    <div class="detail_of_grade">
                                        <div class="float-left float_ar_right"><h2>{{$skillCategory['skill_category_name']}}</h2></div>
                                        {{-- <div class="float-right float_ar_left mrgn-bt-25"><a href="#" class="orng_btn">Start Practice</a></div> --}}
                                        <div class="clearfix"></div>
                                        	@if(Session::get('local') == "ar")
                                              <p class="big_fnt">{{$skillCategory['description_Ar']}}</p>
                                          @elseif(Session::get('local') == "fr")
                                              <p class="big_fnt">{{$skillCategory['description_Fr']}}</p>
                                          @else
                                              <p class="big_fnt">{{$skillCategory['skill_category_decsription']}}</p>
                                          @endif
                                          <div class="clearfix"></div>
                                          @foreach($skillCategory['skill'] as $skill)
                                            <ul class="disk_list">
                                              <li>
                                                {{$skill['skill_name']}}
                                                <div class="float-right float_ar_left mrgn-bt-25">
                                                  {{$skill->grade->grade_name}}
                                                </div>
                                               	@if(Session::get('local') == "ar")
                                                    <p class="big_fnt">{{$skill->description_Ar}}</p>
                                                @elseif(Session::get('local') == "fr")
                                                    <p class="big_fnt">{{$skill->description_Fr}}</p>
                                                @else
                                                    <p class="big_fnt">{{$skill->skill_description}}</p>
                                                @endif
                                              </li>
                                            </ul>
                                          @endforeach
                                    </div>
                                </div>
                              @endforeach
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
</div>
<!---End Content--> 
@endsection
