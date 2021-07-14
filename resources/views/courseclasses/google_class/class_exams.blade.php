@php
   $exams = $googleclass->exams()->get();
      foreach ($exams as $key => $value) {
          if ($value->isavailable == 'N') {
              unset($exams[$key]);
          }
      }
@endphp

<div class="main_summery_earth pd_lf_25">
    <div class="main_detail_fltr">
        <div class="title_with_shrtby">
            <div class="name_list float-left mrgn-tp-0">
                <h4 class="exersc_title">{{ $googleclass->class_name }}</h4>
            </div>
        </div>
          <div class="clearfix"></div>
      </div>
  <div class="list_of_exercise add_nw_exrsc mrgn-tp-0">
        <h4 class="exersc_title">@lang('classcourse.assignments')</h4>
        @if(Auth::user()->hasRole('Teacher') && Auth::user()->id ==  $googleclass->user_id)
            <a href="{{ route('classroom.exam.addexamtoclass',$googleclass->id) }}" class="creat_new pdng_add_btn">@lang('classcourse.Add')</a>
        @endif
        <div class="row" id="assignment-result">
            <!--Filtered result append here from assignment-filter blade-->
            @if(count($exams))
              @foreach($exams as $exam)
              <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                  <div class="main_info pstn_rltv">
                      <div class="main_shr">
                        <button type="button" data-url_link="{{ route('google.classroom.details', [ $googleclass->classid,'#assignments' ])}}"
                            data-exam_title = "{{ $exam->title != '' ? ucfirst(str_limit($exam->title,'30')) : 'N/A' }}"
                           class="share_link_icn" onclick="shareAssignmentsInGoogleClass(this)" data-toggle="tooltip" title="" data-original-title="Share with google classroom"></button>
                      </div>
                      <a class="info_exercise" href="{{ route('courseclasses.assigment.detail',['id' => $exam->id, 'class_id' => $googleclass->user_id]) }}" >
                          <img src="{{asset('assets/eduplaycloud/image/exers_prfl.png')}}" class="img-fluid">
                          <div class="right_gnrl_info">
                              <ul class="gnrl_info float-right float_ar_left">
                                  <li class="messg_lst_i" data-toggle="tooltip" title="" data-original-title="Question">{{$exam->examquestions()->count()}}</li>
                                  <li class="list_i" data-toggle="tooltip" title="" data-original-title="Points">{{$exam->examquestions()->sum('points')}}</li>
                              </ul>
                          </div>
                      </a>
                      @if($exam->teacheruser_id == Auth::user()->id)
                          <button type="button" id="exam_{{$exam->id}}" class="btn delet_request" style="padding-left:43px" onclick="examDelete({{$googleclass->user_id}},{{$exam->id}})"></button>
                      @endif
                      <ul class="title_cmbo text-ar-right">
                          <li><a href="#">{{ $exam->title != '' ? ucfirst(str_limit($exam->title,'30')) : 'N/A' }}</a></li>
                          <li><p>{{ucfirst($exam->examtype)}}</p></li>
                      </ul>
                      <p class="start_end_date"> <span>Start Date : </span>
                          {{@\Carbon\Carbon::parse($exam->pivot->exam_start_date)->format('d-m-Y h:i a')}}
                      </p>
                      <p class="start_end_date">
                          <span>End Date : </span>
                          {{@\Carbon\Carbon::parse($exam->pivot->exam_end_date)->format('d-m-Y h:i a')}}
                      </p>
                      <ul class="editable_list edit_date_avai">
                      @if(Auth::user()->id == $exam->teacheruser_id )
                          <li>
                              <a href="#assignments" id="edit_date_{{ $exam->id }}" 
                                  data-start_date="{{@\Carbon\Carbon::parse($exam->pivot->exam_start_date)->format('d-m-Y h:i a')}}" 
                                  data-end_date="{{@\Carbon\Carbon::parse($exam->pivot->exam_end_date)->format('d-m-Y h:i a')}}" 
                                  data-pivot_id="{{ $exam->pivot->id }}"
                                  data-class_id="{{ $exam->pivot->class_id }}"
                                  
                                  @if(@\Carbon\Carbon::now()->format('d-m-Y') < @\Carbon\Carbon::parse($exam->pivot->exam_start_date)->format('d-m-Y'))
                                      data-is_edit = "true"
                                  @else 
                                      data-is_edit = "false"
                                  @endif
                                  class="edit_wt_icn" onclick="openEditDateModal(this.id)">Date Edit</a>
                          </li>
                      @endif
                          <li>
                              <div class="availble">
                                  @if($exam->isavailable === 'Y')
                                      <p>@lang('classcourse.Availble')</p>
                                  @else 
                                      <p>@lang('classcourse.Not Availble')</p>
                                  @endif
                              </div>
                          </li>
                      </ul>
                      @php 
                          $classexam=\App\Models\GoogleclassExams::findorfail($exam->pivot->id);
                      @endphp
                      @can ('tackExamGoogle' ,$classexam)
                           <a href="{{route('takeexam.index' ,[$exam->id , $exam->pivot->class_id , $isexam="1", 'examtype' => 'google'])}}" class="creat_new assign_take">@lang('classcourse.take_assignment')</a>
                      @endcan
                      @can ('getresultGoogle' ,$classexam)
                          <a href="{{route('takeexam.score',[$exam->pivot->id ,$isexam="1",'examtype' => 'google'])}}" class="btn submit_btn" >@lang('classcourse.show_result')</a>        
                      @endcan

                  </div>
              </div>
              @endforeach
              @else 
                  <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                      <p>@lang('classcourse.no_assignments_available')</p>
                  </div>
              @endif

        </div>
    </div>
</div>