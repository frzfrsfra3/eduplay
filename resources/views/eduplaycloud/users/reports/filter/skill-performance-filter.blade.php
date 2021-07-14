@if (!is_null($skilldata) && !empty($skilldata))
@foreach ($skilldata->courseclass->skillCategory as $sckey => $scskill)
@foreach ($scskill->skill as $key => $skill)
    @php
        $skillId = $skill->id;

        if (isset($skill->exam->classexam) && !empty($skill->exam->classexam)):
            $classExam = $skill->exam->classexam;
        else:
            $classExam = '';
        endif;
    @endphp
    <tr class="clickable-row" data-href="{{ route('exerciseSetReport',[$classId,$userId,$skillId])}}">
        <td>
            <div
                @php $classExamId=''; @endphp
                @if (!is_null($classExam) && !empty($classExam))
                    @foreach ($classExam as $classexam)
                        @php
                            $classExamId=$classexam->id;
                            $level = QueryHelper::userSkillMasterylevel($user->id,$skillId,$classExamId);
                        @endphp
                        @if(!empty($level->skillmasterylevel))
                            @if ($levelname=$level->skillmasterylevel->id === 5)
                                class="switches_bx swc_green"
                            @elseif ($levelname=$level->skillmasterylevel->id === 4)
                                class="switches_bx swc_blue"
                            @elseif ($levelname=$level->skillmasterylevel->id === 3)
                                class="switches_bx swc_light_yellow"
                            @elseif ($levelname=$level->skillmasterylevel->id === 2)
                                class="switches_bx swc_yellow"
                            @else
                                class="switches_bx swc_red"
                            @endif
                        @else
                            class="switches_bx swc_red"
                        @endif
                    @endforeach
                @endif
            ></div>
            {{$scskill->skill_category_name}} / {{ $skill->skill_name }}
        </td>
        <td>
            @if (isset($skill->skillQuestion) && !empty($skill->skillQuestion))
                @php $que=1; @endphp
                    @foreach ($skill->skillQuestion as $question)
                        @php $c=$que++; @endphp
                    @endforeach
                {{ $c }}
            @else
                <p>@lang('profile.not_available')</p>
            @endif
        </td>
        <td>
            @if (isset($skill->skillQuestion) && !empty($skill->skillQuestion))
                @php $ans=0; @endphp
                @foreach ($skill->skillQuestion as $question)
                    @foreach($question->getUserExamAnswere as $answer)
                    {{--  {{ $answer->iscorrect }}  --}}
                        @if($answer->iscorrect == 1)
                            @php $a=$ans++; @endphp
                        @endif
                    @endforeach
                @endforeach
                {{ $ans }}
            @else
                <p>@lang('profile.not_available')</p>
            @endif
        </td>
        <td>
            @if (isset($skill->exam->classexam) && !empty($skill->exam->classexam))
                @foreach ($skill->exam->classexam as $classexam)
                    @php
                        $classExamId=$classexam->id;
                        $level = QueryHelper::userSkillMasterylevel($user->id,$skillId,$classExamId);
                        if(!empty($level->skillmasterylevel)){
                            echo $levelname=$level->skillmasterylevel->levelname;
                        }else{
                            echo "@lang('profile.not_available')";
                        }
                    @endphp
                @endforeach
            @else
                <p>@lang('profile.not_available')</p>
            @endif
        </td>
        <td>
            @php
                $learnerCount;
                $allLevel = QueryHelper::allSkillMasterylevel($skillId,$classExamId);
            @endphp
            <div class="progress tp_bar_prgress">
            @if (isset($allLevel) && !empty($allLevel))
                @php
                    $notStarted =0;
                    $needsMorePractice =0;
                    $underAcquisition =0;
                    $acquired =0;
                    $mastered =0;
                @endphp
                @foreach ($allLevel as $levels)
                    @if($levels->masteryLevel == 5)
                        @if($levels->masteryLevel == 5)
                            @php $mastered++; @endphp
                        @else
                            @php $mastered=0; @endphp
                        @endif
                    @endif

                    @if($levels->masteryLevel == 4)
                        @if($levels->masteryLevel == 4)
                            @php $acquired++; @endphp
                        @else
                            @php $acquired=0; @endphp
                        @endif
                    @endif

                    @if($levels->masteryLevel == 3)
                        @if($levels->masteryLevel == 3)
                            @php $underAcquisition++; @endphp
                        @else
                            @php $underAcquisition=0; @endphp
                        @endif
                    @endif

                    @if($levels->masteryLevel == 2)
                        @if($levels->masteryLevel == 2)
                            @php $needsMorePractice++; @endphp
                        @else
                            @php $needsMorePractice=0; @endphp
                        @endif
                    @endif

                    @if($levels->masteryLevel == 1)
                        @if($levels->masteryLevel == 1)
                            @php $notStarted++; @endphp
                        @else
                            @php $notStarted=0; @endphp
                        @endif
                    @endif
                @endforeach

                {{--  {{ round(($mastered/$learnerCount)*100)}}
                {{ round(($acquired/$learnerCount)*100)}}
                {{ round(($underAcquisition/$learnerCount)*100)}}
                {{ round(($needsMorePractice/$learnerCount)*100)}}
                {{ round(($notStarted/$learnerCount)*100)}}  --}}
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ round(($mastered/$learnerCount)*100) }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-confirm" role="progressbar" style="width: {{ round(($acquired/$learnerCount)*100) }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ round(($underAcquisition/$learnerCount)*100) }}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>

                <div class="progress-bar" role="progressbar" style="width: {{ round(($needsMorePractice/$learnerCount)*100) }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>

                <div class="progress-bar progress_unscces" role="progressbar" style="width: {{ round(($notStarted/$learnerCount)*100) }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            @else
                <div>Not available</div>
            @endif
            </div>
        </td>
    </tr>
@endforeach
@endforeach
@else
<tr>
    <td colspan="5">@lang('profile.not_available') !!</td>
</tr>

@endif