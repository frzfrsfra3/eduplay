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
                        @if($isexam =='0')
                            <li class="breadcrumb-item">
                              @if($examFrom == NULL)
                                <a href="{{ route ('courseclasses.courseclass.show', $classexam->class_id . '#assignments') }}" > {{ $classexam->class->class_name }}   </a>
                              @else 
                                <a href="{{ route ('google.classroom.details', $classexam->class_id . '#assignments') }}" > {{ $classexam->class->name }}   </a>
                              @endif
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/courseclasses/show/{{$classexam->class_id}}" >
                                    {{ isset($classexam->class->class_name) ? $classexam->class->class_name : 'No class name' }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                    {{ isset($classexam->exam->title) ? $classexam->exam->title : 'No Exam name' }}
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">
                              @if($examFrom == NULL)
                                <a href="{{ route ('courseclasses.courseclass.show', $classexam->class_id . '#assignments') }}" > {{ $classexam->class->class_name }} </a>
                              @else 
                                <a href="{{ route ('google.classroom.details', $classexam->class_id . '#assignments') }}" > {{ $classexam->class->name }}   </a>
                              @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">  
                                    {{ $classexam->exam->title }} 
                            </li>
                        @endif
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-xl-9">
                        <div class="done_bx">
                            <div class="thmb_i"></div>
                            <div class="top_d_bx">
                                <h3>{{ $message }} {{ Auth::user()->name }}</h3>
                                <ul class="sprl_tp_info">

                                    <li>
                                        <h3> {{$correctanswers}}/ {{ $classexam->exam->examquestions()->count()}}</h3>
                                        <p>Correct Answers</p>
                                    </li>
                                    <li>
                                        <h3> {{$badanswers}}/ {{ $classexam->exam->examquestions()->count()}}</h3>
                                        <p>Incorrect Answers</p>
                                    </li>
                                    <li>
                                        <h3>{{ date("H:i:s", $userexamscore->totaltimespent)  }}</h3>
                                        <p>Minutes Taken</p>
                                    </li>
                                </ul>
                                {{-- <button type="button" class="btn btn-primary add_btn orgng_btn">Mastered</button> <i class="exm_i"></i> --}}
                            </div>
                            <div class="top_d_bx">
                                @foreach($uniqueSkillcategory as $skillcategory) 
                                    <div class="row">
                                        <div class="col-xl-3 col-xl-3-14"><h3>{{ $skillcategory['skill_category_name'] }}</h3></div>
                                        <div class="col-xl-5 col-xl-5-14 text-right-def">
                                            <a href="{{route('skillPerformanceViewbyTest',[$classexam->class_id, Auth::user()->id])}}" class="btn btn-primary add_btn view_rep_btn mrg-right-15">View Report</a>
                                        </div>
                                        <div class="col-xl-8 col-xl-8-14">
                                            <p>{{ $skillcategory['skill_category_decsription'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group mrgn-bt-50 mrgn-tp-40">
                                {{-- <a href="{{ route ('courseclasses.courseclass.show', $classexam->class_id . '#assignments') }}"  class="btn btn-primary add_btn mrg-right-15" >Close</a> --}}
                                @if($examFrom == NULL)
                                  <a href="{{ route ('courseclasses.courseclass.show', $classexam->class_id . '#assignments') }}" class="btn btn-primary add_btn mrg-right-15">@lang('practice.continue')</a>
                                @else 
                                  @php
                                    $class = \App\Models\GoogleClassroom::findorfail($classexam->class_id);
                                  @endphp
                                  <a href="{{ route ('google.classroom.details', $class->classid) }}" class="btn btn-primary add_btn mrg-right-15">@lang('practice.continue')</a>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <input type="hidden" id="current_url" val ="{{Request::url() }}">
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

@push('inc_script')
<script>

$(document).ready(function(){
    var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
     //   var clean_uri = uri.substring(0, uri.indexOf("?"));
       window.history.replaceState({}, document.title, uri);
    }
});

</script>
@endpush


