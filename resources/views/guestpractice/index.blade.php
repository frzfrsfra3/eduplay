@extends('authenticated.layouts.default')
@section('content')
<?php /*Load jquery to footer section*/ ?>
@push('inc_css')
@endpush
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="pdng_60_lft">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="disciplines_details.html">{{ $exerciseset->topics->topic_name}}</a></li>
                            <li class="breadcrumb-item"><a href="math_disciplines_details.html">{{ $exerciseset->discipline->discipline_name}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$skill->skill_name}}</li> --}}
                        </ol>
                    </nav>
                    @php
                        $countcorrectanswer=0;
                        $countbadanswer=0;
                    @endphp                    
                    @if($question)
                        @if(Session::has('countofcorrectanswer'.$question->exercise_id))
                            @php                
                                $countcorrectanswer=session('countofcorrectanswer'.$question->exercise_id);
                            @endphp
                        @endif                
                        @if(Session::has('countofbadanswer'.$question->exercise_id))
                            @php
                                $countbadanswer=session('countofbadanswer'.$question->exercise_id);
                            @endphp
                        @endif
                    @endif
                    
                    {{-- @include('guestpractice.practicevigation',[$exerciseset ]) --}}
                    
                    <div class="main_summery_earth dcspln_inner_main main_sprl_pr">
                        @if ($question)
                            @include ('guestpractice.question', [ $question,$exerciseset ,$nextquestionid,$countcorrectanswer   ])
                        @else
                            There is no Question availble for your topic selection .
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
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/new-practice.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/js/practice.js') }}"></script> --}}
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

@endpush
