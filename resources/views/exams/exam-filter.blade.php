


@if(count($exams) == 0)
<div class="panel-body text-center">
    <div class="col-sm-12">
        <p>@lang('exam.no_exams_available')</p>
    </div>
</div>
@else
@php $i=1;@endphp
@foreach($exams as $exam)
    @php $k=$i%2; $i++ ;@endphp
    <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col exam-header-row-{{$k}}">
        <div class="main_info pstn_rltv">
            <div class="main_shr">
                <button type="button" data-exerciseset="{{route('takeexam.index' ,[$exam->id , $exam->class_id($exam->id) ,"1"])}}" 
                    id="share_{{$exam->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private" 
                    data-toggle="tooltip" title="@lang('exercisesets.share')"
                    class="share_link_icn">
                </button>
            </div>
            <div class="info_exercise">
                <img src="assets/eduplaycloud/image/assignment_bg.png" class="img-fluid">
                <div class="right_gnrl_info">
                    <ul class="gnrl_info float-right float_ar_left">
                        <li class="messg_lst_i"  data-toggle="tooltip" title="Question">{{$exam->examquestions()->count()}}</li>
                        <li class="list_i"  data-toggle="tooltip" title="Points">{{$exam->examquestions()->sum('points')}}</li>
                    </ul>
                </div>
            </div>
            <ul class="title_cmbo text-ar-right">
                <li><a>{{ $exam->title != '' ? ucfirst(str_limit($exam->title,'30')) : 'N/A' }}</a></li>
                <li>
                    <p>{{ucfirst($exam->examtype)}}</p>
                </li>
            </ul>
            <div class="availble">
                <p>{{ $exam->isavailable =='N' ? Lang::get('exam.not_available') : Lang::get('exam.available') }} </p>
            </div>
            <ul class="editable_list">
                <li><a href="javascript:;" class="view_icn" data-id="{{ $exam->id }}">@lang('exam.view')</a></li>
                <li><a class="edit_wt_icn" href="{{ route('exams.exam.edit', array($exam->id,$exams->currentPage()) ) }}">@lang('exam.edit')</a></li>
                <li><a href="javascript:;" class="export_icn" data-id="{{ $exam->id }}">@lang('exam.export')</a></li>
                {{--  <li><a class="export_icn" href="{{ route('exams.exam.exportExam',$exam->id) }}">Export</a></li>  --}}
                <li><a class="delet_wt_icn" href="{!! route('exams.exam.destroy', $exam->id) !!}"  onclick="return confirm('Delete Exam?')">@lang('exam.delete')</a></li>
            </ul>
            @if ( $exam->examtype == "practice")
                <a href="{{ route('games.generate.exam.code' , $exam->id) }}" class="creat_new" style="font-size: 11px !important">Generate game code</a>
            @endif
            @if ( auth()->user()->hasRole('Learner'))
            <a href="{{ route('practice.index', $exam->id ) }}" class="creat_new assign_take m3">@lang('exam.take_assignment')</a>
            @endif
        </div>
    </div>
@endforeach


@endif