@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="pdng_60_lft">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{route('exercisesets.exerciseset.show',[$exerciseset->id,$exerciseset->publish_status === 'public' ? 1 : 0])}}">{{$exerciseset->title}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$exerciseset->discipline->discipline_name}}</li> --}}
                        <li class="breadcrumb-item"><a href="{{route('exercisesets.exerciseset.private')}}">@lang('exerciseset_show.my_private_exercise')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $exerciseset->title }}</li>
                    </ol>
                </nav>
                <div class="main_summery_earth dcspln_inner_main">
                    @if(count($skill_category))
                        <form method="POST" action="{{route('questions.linked')}}" id="skill_form">
                        @csrf    
                        <input type="hidden" name="exerciseset_id" value="{{$exerciseset->id}}">
                        <input type="hidden" name="exerciseset_public" value="{{$exerciseset->publish_status === 'public' ? 1 : 0}}">
                        <input type="hidden" name="questions" value="{{$question_ids}}">
                        <input type="hidden" name="skill_category_id" value="" id="hidden_skill_category_id">
                        <input type="hidden" name="skill_id" id="hidden_skill_id" value=""/>
                        <div class="row">
                        @foreach($skill_category as $skillCatKey => $skill_cate)
                        @if(count($skill_cate->skill))  
                          @if($skill_cate->skill->where('grade_id','=',$exerciseset->grade_id)->first())
                          <div class="col-md-12"><h3 class="font_30_sb">{{$skill_cate->skill_category_name}}</h3></div>
                              <div class="col-md-12 mrgn-bt-30">
                                  <div class="skill-blade-ctgry exercise_reprt center-block mrgn-tp-30">
                                      <div class="deatil_panneel_privt pannel_exercise panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                              <div class="deatil_panneel_privt inner_pannel panel panel-default">
                                                  <div class="panel-heading active" role="tab" id="headingOne">
                                                      <div class="panel-title">
                                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_{{$skill_cate->id}}" aria-expanded="false" aria-controls="collapseOne_{{$skill_cate->id}}">
                                                              {{-- <p>{{ $skill_cate->skill_category_name }}</p> --}}
                                                              @if(Session::get('local') == "ar")
                                                                  <p class="big_fnt">{{$skill_cate->description_Ar}}</p>
                                                              @elseif(Session::get('local') == "fr")
                                                                  <p class="big_fnt">{{$skill_cate->description_Fr}}</p>
                                                              @else
                                                                  <p class="big_fnt">{{$skill_cate->skill_category_decsription}}</p>
                                                              @endif
                                                          </a>
                                                      </div>
                                                  </div>
                                                  <div id="collapseOne_{{$skill_cate->id}}" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                      <div class="panel-body">
                                                          <ul class="ans_list">
                                                            {{-- @if(count($skill_cate->skill)) --}}
                                                              @foreach($skill_cate->skill as $key => $skill)
                                                              @if($skill->grade_id === $exerciseset->grade_id)
                                                              <li>
                                                                  <div class="detail_of_grade">
                                                                          <div class="float-left float_ar_right"><h5>{{$skill->skill_name}}</h5></div>
                                                                          <div class="float-right float_ar_left">
                                                                              <input type="radio"  id="skill_{{$skill->id}}" value="{{$skill->id}}"  class="custom-control-input radio">
                                                                              <label class="orng_btn select-skill" data-skill_cate="{{$skill_cate->id}}" data-skill_id="{{ $skill->id }}" for="skill_{{$skill->id}}">@lang('messages.select_skill')</label>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                    <p class="big_fnt">{{$skill->skill_description}}</p>
                                                                      <ul class="disk_list">
                                                                          <li>{{$skill->grade->grade_name}}</li>
                                                                      </ul>
                                                                  </div>
                                                              </li>
                                                              @endif
                                                              @endforeach
                                                              {{-- @else  --}}
                                                              {{-- <li> --}}
                                                                  {{-- @lang("messages.no_skill_available") --}}
                                                              {{-- </li> --}}
                                                          </ul>
                                                      </div>
                                                  </div>
                                              </div>                                          
                                      </div>
                                  </div>
                              </div>
                              @endif
                              @endif
                              @endforeach
                          </div>
                          </form>
                          {{-- @endif --}}
                        @else
                        <div class="row"><div class="col-md-12"><p>@lang("messages.no_skill_available")</p></div></div>
                        @endif
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
$('.select-skill').on('click', function(){
    
    // Update hidden fields
    $('#hidden_skill_id').val($(this).data('skill_id'));
    $('#hidden_skill_category_id').val($(this).data('skill_cate'));

    setTimeout(function(){ 
        $('#skill_form').submit();
     }, 300);
});
</script>
<script>
    // Accordion
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
@endpush
