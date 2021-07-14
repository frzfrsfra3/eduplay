@if(count($exams))
@foreach($exams as $exam)
<div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
    <div class="main_info pstn_rltv">
        <a class="info_exercise" href="{{ route('courseclasses.assigment.detail',['id' => $exam->id, 'class_id' => $class_id]) }}" >
            <img src="{{asset('assets/eduplaycloud/image/exers_prfl.png')}}" class="img-fluid">
            <div class="right_gnrl_info">
                <ul class="gnrl_info float-right float_ar_left">
                    <li class="messg_lst_i" data-toggle="tooltip" title="" data-original-title="Question">{{$exam->examquestions()->count()}}</li>
                    <li class="list_i" data-toggle="tooltip" title="" data-original-title="Points">{{$exam->examquestions()->sum('points')}}</li>
                </ul>
            </div>
        </a>
        @if($exam->teacheruser_id == Auth::user()->id)
            <button type="button" id="exam_{{$exam->id}}" class="btn delet_request" onclick="examDelete({{$class_id}},{{$exam->id}})"></button>
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
                $classexam=\App\Models\Classexam::findorfail($exam->pivot->id)  ;
        @endphp
    
        @can ('takeexam' ,$classexam)
            <a href="{{route('takeexam.index' ,[$exam->id , $exam->pivot->class_id , $isexam="1"])}}" class="creat_new assign_take">@lang('classcourse.take_assignment')</a>
        @endcan
        @can ('getresult' ,$classexam)
            <a href="{{route('takeexam.score',[$exam->pivot->id ,$isexam="1"])}}" class="btn submit_btn" >@lang('classcourse.show_result')</a>        
        @endcan

    </div>
</div>
@endforeach
@else 
    <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
        <p>@lang('classcourse.no_assignments_available')</p>
    </div>
@endif
<script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
</script>