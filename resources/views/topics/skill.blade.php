 @extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="pdng_60_lft">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('topics.topic.index') }}">
                            <!--Check if topic name exists or not-->
                            @if (isset($exercisets->first()->topics->topic_name)) 
                                {{ $exercisets->first()->topics->topic_name }}
                            @endif
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $exercisets->first()->discipline->discipline_name }}</li>
                        </ol>
                    </nav>
                    <div class="main_summery_earth dcspln_inner_main">
                        <div class="row">
                            <div class="col-md-12"><h3 class="font_30_sb">{{ $exercisets->first()->discipline->discipline_name }}</h3></div>
                            <div class="col-md-12 text-right">
                                <div class="short_by">
                                    <div class="short_by_select nw_algn">
                                        <label>@lang("filter.sort_by"):</label>
                                        <select class="selectpicker" id="sort_by">
                                            <option value="grade">@lang("filter.grade")</option>
                                            <option value="skill">@lang("filter.skill")</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                         <div class="col-md-12"> 
                            @guest
                            <form method="POST" action="{{route('guest.guestpractice')}}" id="skill_form">
                            @endGuest

                            @Auth
                            <form method="POST" action="{{route('practice.userdisciplinepractice')}}" id="skill_form">
                            @endAuth
                                @csrf
                                <input type="hidden" name="exercisets_ids" value="{{$exercisets_ids}}">
                                <section class="row" id="grade_section">
                                @foreach($exercisets as $exKey => $exerciset)
                                  <div class="col-md-12"><h6 class="grd_title">{{ $exerciset->grade->grade_name }} </h6></div>
                                  @if(count($exerciset->skill_category) > 0)
                                      <div class="col-md-12 mrgn-bt-30">
                                          <div class="bd-example bd-example-tabs">
                                              <div class="row">
                                                  <div class="col-md-4 col-xl-3 pdn_rigt_less">
                                                      @php
                                                        $count = 0; 
                                                        $show = '';
                                                      @endphp
                                                      <div class="grade_tabs nav flex-column nav-pills" id="v-pills-tab{{$exerciset->grade->id}}" role="tablist" aria-orientation="vertical">
                                                        @foreach($exerciset->skill_category as $skillCatKey => $skill_cate)
                                                          @if(count($skill_cate->skill))
                                                            @php
                                                              $count++;
                                                              $count == 1 ? $show = 'active show' : $show =  '' ;
                                                            @endphp
                                                            
                                                          <a class="nav-link {{$show}}" id="v-pills-dynamic-tab{{ $skill_cate->id }}" data-toggle="pill" href="#v-pills-dynamic{{ $skill_cate->id }}" role="tab" aria-controls="v-pills-dynamic{{ $skill_cate->id }}" aria-selected="false">{{$skill_cate->skill_category_name}}</a>
                                                          @endif
                                                        @endforeach
                                                      </div>
                                                  </div>
                                                  <div class="col-md-8 col-xl-9 pdn_left_less">
                                                      @php
                                                        $tabCount = 0; 
                                                        $tabShow = '';
                                                      @endphp
                                                      <div class="tab-content inner_grade_panel" id="v-pills-tabContent{{$exerciset->grade->id}}">
                                                        @foreach($exerciset->skill_category as $skillCatKey => $skill_cate)
                                                          @if(count($skill_cate->skill))
                                                           @php
                                                              $tabCount++;
                                                              $tabCount == 1 ? $tabShow = 'active show' : $tabShow =  '' ;
                                                            @endphp
                                                          <div class="tab-pane fade {{ $tabShow }}" id="v-pills-dynamic{{ $skill_cate->id }}" role="tabpanel" aria-labelledby="v-pills-dynamic-tab{{ $skill_cate->id }}">
                                                              <div class="detail_of_grade">
                                                                   <div class="detail_of_grade">
                                                                        <div class="float-left float_ar_right"><h2> {{ $skill_cate->skill_category_name  }}</h2></div>
                                                                        <div class="clearfix"></div>
                                                                        <p class="big_fnt">
                                                                            @if(Session::get('local') == "ar")
                                                                                <p class="big_fnt">{{$skill_cate->description_Ar}}</p>
                                                                            @elseif(Session::get('local') == "fr")
                                                                                <p class="big_fnt">{{$skill_cate->description_Fr}}</p>
                                                                            @else
                                                                                <p class="big_fnt">{{$skill_cate->skill_category_decsription}}</p>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                     @foreach($skill_cate->skill as $skill)
                                                                        <div class="detail_of_grade">
                                                                            <div class="float-right float_ar_left mrgn-bt-25">
                                                                                @if(count($skill->skillQuestion) > 0)
                                                                                <input type="radio" name="skill_with_skill_category"  id="skill_{{$skill->id}}" value="{{$skill->skill_category_id}},{{$skill->id}}" class="custom-control-input radio" >
                                                                                <label class="orng_btn select-skill" style="cursor:pointer !important;position: relative; z-index: 9;" for="skill_{{$skill->id}}">@lang("messages.start_practice")</label>
                                                                                @endif
                                                                                <p class="grade-question-count">@lang("exerciseset_show.questions") : {{ $skill->skillQuestion->where('skillcategory_id','=' ,$skill_cate->id)->count()}}</p>
                                                                                
                                                                            </div>
                                                                            <ul class="disk_list">
                                                                                <li>{{ $skill->skill_name  }}</li>
                                                                            </ul>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                    @endforeach
                                                              </div>
                                                          </div>
                                                          @endif
                                                        @endforeach
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endif
                                @endforeach
                                </section>

                                <!--sort by skills-->
                                    <section class="hide" id="skill_section">
                                        {{-- @foreach($exercisets as $exKey => $exerciset)
                                            @if(count($exerciset->sort_by_skill) > 0)
                                                <h6 class="grd_title mrgn-bt-40">@lang("messages.skills")</h6>
                                                <div class="row">
                                                 @php
                                                    $skilltabCount = 0; 
                                                    $skilltabShow = '';
                                                  @endphp
                                                    @foreach($exerciset->sort_by_skill as $skillCatKey => $skill_cate)
                                                        @if(count($skill_cate->skill))
                                                          @php
                                                            $skilltabCount++;
                                                            $skilltabCount == 1 ? $skilltabCount = 'checked' : $skilltabCount =  '' ;
                                                          @endphp
                                                        <div class="col-md-6">
                                                            <div class="skill_box">
                                                                <h4> {{ $skill_cate->skill_category_name  }} </h4>
                                                                <div class="row">
                                                                    @foreach($skill_cate->skill as $skill)
                                                                      
                                                                        <div class="col-md-4 col-xl-5"><p>{{ $skill->skill_name }}</p></div>
                                                                        <div class="col-md-	 col-xl-3"><h6>{{ $skill->grade->grade_name  }}</h6></div>
                                                                        <div class="col-md-4">
                                                                            <div class="float-right float_ar_left">
                                                                                <input type="radio" name="skill_with_skill_category" id="srt_skill_{{$skill->id}}" value="{{$skill->skill_category_id}},{{$skill->id}}"  class="custom-control-input radio" {{ $skilltabCount }} >
                                                                                <label class="orng_btn select-skill" for="srt_skill_{{$skill->id}}">@lang("messages.start_practice")</label>
                                                                                <div class="clearfix"></div>
                                                                                <p class="skill-question-count">@lang("exerciseset_show.questions") : {{ count($skill->skillQuestion)}}</p>
                                                                                <br/>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    @endforeach
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>@lang('messages.no_data_available')</p>
                                            @endif
                                        @endforeach --}}

                                        
                                        @foreach($skillExercisets as $discipline)
                                            @if(count($discipline->skillcategories) > 0)
                                                <h6 class="grd_title mrgn-bt-40">@lang("messages.skills")</h6>
                                                <div class="row">
                                                    @foreach($discipline->skillcategories as $key => $skillcategories)
                                                      {{-- @if(count($skillcategories->skill->where('grade_id','=',$exerciset->grade_id)) > 0)  --}}
                                                        <div class="col-md-6">
                                                            <div class="skill_box">
                                                                <h4> {{ $skillcategories->skill_category_name  }} </h4>
                                                                <div class="row">
                                                                    @foreach($skillcategories->skill as $skill)
                                                                        {{-- @if($skill->grade_id === $exerciset->grade_id) --}}
                                                                        <div class="col-md-4 col-xl-5"><p>{{ $skill->skill_name }}</p></div>
                                                                        <div class="col-md-  col-xl-3"><h6>{{ $skill->grade->grade_name  }}</h6></div>
                                                                        <div class="col-md-4">
                                                                            <div class="float-right float_ar_left">
                                                                                @if(count($skill->skillQuestion) > 0)
                                                                                <input type="radio" name="skill_with_skill_category" id="srt_skill_{{$skill->id}}" value="{{$skill->skill_category_id}},{{$skill->id}}"  class="custom-control-input radio"  {{$key === 0 ? 'checked' : '' }} >
                                                                                <label class="orng_btn select-skill" for="srt_skill_{{$skill->id}}">@lang("messages.start_practice")</label>
                                                                                <div class="clearfix"></div>
                                                                                @endif
                                                                                <p class="skill-question-count">@lang("exerciseset_show.questions") : {{ count($skill->skillQuestion)}}</p>
                                                                                <br/>
                                                                            </div>
                                                                        </div>
                                                                        {{-- @endif --}}
                                                                    @endforeach
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                      {{-- @endif --}}
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>@lang('messages.no_data_available')</p>
                                            @endif
                                        @endforeach
                                    </section>
                                <!--end sort by skills-->

                            </form>
                        </div>
                        </div>
                        <div class="clearfix"></div>
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
<script>
//Onchage sort by skill and grade section display
$('#sort_by').on('change', function(){
    var sort_by = $(this).val();
    if(sort_by === 'grade'){
        $('#grade_section').slideDown();
        $('#skill_section').slideUp();
    } else {
        $('#grade_section').slideUp();
        $('#skill_section').slideDown();
    }
})

$('.select-skill').on('click', function(){
    var id  = $(this).attr('for');
    if($('#' + id).prop('checked', true)){
        $('#skill_form').submit();
    }
});
</script>
<script>
    // Accordion
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();        
    });

    $(window).bind("pageshow", function() {
        $("#sort_by").val('grade').selectpicker("refresh");
     });

</script>
@endpush