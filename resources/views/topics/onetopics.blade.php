 @if (count($topics) == 0)


<div class="panel-body text-center">
    <p>@lang('topic.no_disc_available')</p>
</div>
@else
<div class="row dscpln_list">
    @foreach($topics as $topic)
    <div class="col-sm-6 col-lg-3">
        <div class="discipline_bx">
            @php
                if (!Auth::guest()):
                    $authUserId = Auth::user()->id;
                    $strHvrPush = 'str-hvr-push';
                else:
                    $authUserId = 0;
                    $strHvrPush = '';
                endif;

                if ($topic->getUserInterests()->where('user_id', $authUserId)->count() > 0):
                    $star = 'strs_btn selected_star';
                else:
                    $star = 'strs_btn';
                endif;

                $userInterestsObj = $topic->getUserInterests()->where('user_id', $authUserId)->select('id', 'discipline_id', 'topic_id', 'language_id', 'grade_id', 'exercise_type', 'user_id')->get()->toArray();
                if (isset($userInterestsObj[0]['id']) && !empty($userInterestsObj[0]['id'])) {
                    $userInterestsId = $userInterestsObj[0]['id'];
                } else {
                    $userInterestsId = 0;
                }

                if (isset($userInterestsObj[0]['discipline_id']) && !empty($userInterestsObj[0]['discipline_id'])) {
                    $userInterestsDId = $userInterestsObj[0]['discipline_id'];
                    $dcpln_btn = '';
                } else {
                    $userInterestsDId = 0;
                    $dcpln_btn = 'dcpln_btn';
                }
            @endphp
            <a href="javascript:;" class="dcpln_a {{ $dcpln_btn }}">
                @if (strlen($topic->iconurl) == 0 || !File::exists(public_path()."/assets/images/".$topic->iconurl))
                    <img src="//dummyimage.com/300/cfcfcf/000000.png&text=No+Image" class="borderRadius100" alt="{{ $topic->discipline_name }}">
                @else
                    <img src="{{ asset('assets/images/'.$topic->iconurl) }}" alt="{{ $topic->discipline_name }}">
                @endif
                <h5>{{ $topic->topic_name }}</h5>
                <ul class="bl_or_txt">
                    <li>@lang('explore.curriculum') : {{ $topic->discipilnes()->where(['approve_status' => 'approved'])->where(['publish_status' => 'published'])->count() }}</li>
                    <li class="orng_li">@lang('explore.exercises_set'): {{ $topic->exercisesetsfilter_count }}</li>
                </ul>
            </a>
            <a href="javascript:;" class="stngs_btn hvr-push discipline_{{ $topic->id }}" data-topic-id="{{ $topic->id }}" data-topic-name="{{ $topic->topic_name }}" data-interested-id="{{ $userInterestsId }}" data-exe-count="{{ $topic->exercisesetsfilter_count }}"></a>
            {{--  {{ $topic->exercisesets->count() }}  --}}
            @if(Auth::user())
                <button class="{{ $star }} hvr-push str-hvr-push {{ $strHvrPush }} topic_{{ $topic->id }}" data-topic-id="{{ $topic->id }}"></button>
            @endif
        </div>
    </div>
    @endforeach
</div>
<div class="clearfix"></div>
@endif