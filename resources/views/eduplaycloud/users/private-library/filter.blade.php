@if(count($myExercises))
@foreach($myExercises as $exerciseset)
@php
$ispublic = 0;
$rn = rand(1,3);
@endphp
<div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
  <div class="main_info">
    <div class="main_shr">
      <button type="button" data-exerciseset="{{route('mail.exerciseset.show', [ $exerciseset->id  , ($exerciseset->publish_status === 'public' ) ? 1 : 0 ])}}" 
        id="share_{{$exerciseset->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private" 
        data-toggle="tooltip" title="@lang('exercisesets.share')"
        class="share_link_icn">
      </button>
    </div>
    <a href="@can ('update', $exerciseset){{route('exercisesets.exerciseset.show', [ $exerciseset->id  , ($exerciseset->publish_status === 'public' ) ? 1 : 0 ])}}@endcan">
      <div class="info_exercise">
        @php
        if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
        if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
        $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
        } else {
        $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
        }
        } else {
        $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
        }
        @endphp
        <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
        <div class="whit_checbx">
          <div class="custom-control checkbox custom-checkbox chbx_wt">
            @if (Auth::user()->hasRole('Teacher'))
            <input name="exerses[]" value="{{$exerciseset->id}}" id="exerses_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
            <label class="custom-control-label" for="exerses_{{$exerciseset->id}}"></label>
            @endif
          </div>
        </div>
        <div class="left_time_info">
          <ul class="time_info float-left">
            <li>
              @if ($exerciseset->price != 0)
              ${{ $exerciseset->price }}
              @else
              @lang('exercisesets.free')
              @endif
            </li>
            <li class="time_icn">
              {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}
            </li>
          </ul>
          <ul class="skill_info float-right">
            <li>
              @lang('exercisesets.skills'):
              {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
            </li>
            <li>
              @lang('exercisesets.question'):
              {{ $exerciseset->question->count() }}
            </li>
          </ul>
        </div>
      </div>
      <ul class="creat_exr title_cmbo">
        <li>
          <label class="pointer" title="{{$exerciseset->title}}">{{ str_limit($exerciseset->title,'30') }}</label>
        </li>
        @if($exerciseset->discipline)
        <li>
          <span>{{  str_limit(@$exerciseset->discipline->discipline_name, '50') }}</span>
        </li>
        @else 
        <li><span>@lang('filter.n/a')</span></li>
        @endif
         <li>
            @if($exerciseset->publish_status == 'private')
                <span>@lang('exerciseset_form.private')</span>
            @else
                <span>@lang('exerciseset_form.public')</span>
            @endif
        </li>
      </ul>
    </a>
    @if(Auth::user()->id == $exerciseset->createdby)
        <form id="remove_exercise_from_{{$exerciseset->id}}" method="POST" action="{{route('exercisesets.owner.destroy', [$exerciseset->id])}}">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button class="btn my_exercises_delete" onclick="confirmFunction({{$exerciseset->id}})" type="button"></button>
      </form>
    @endif
    @if(Auth::user()->hasRole('Admin'))
      <form id="remove_exercise_from_{{$exerciseset->id}}" method="POST" action="{{route('exercisesets.owner.destroy', [$exerciseset->id])}}">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button class="btn my_exercises_delete" onclick="confirmFunction({{$exerciseset->id}})" type="button"></button>
      </form>
    @endif
    <ul class="star_wth_user">
      <li>
        <div class="gray_star">
          <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
        </div>
        <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
      </li>
      @if($exerciseset->grade)
      <li title="{{ $exerciseset->grade->grade_name }}"><span>{{ str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
      @else 
      <li><span>@lang('filter.n/a')</span></li>
      @endif
      <li><small>{{ $exerciseset->created_at }}</small></li>
    </ul>
    @foreach($exerciseRatingList as $ratekey => $rate)
    @php $reviewCount = 1; @endphp
    @if($rate->id == $exerciseset->id)
    @if(count($rate->ratings_data) > 0)
    @foreach($rate->ratings_data as $item)
    {{-- @if($reviewCount < 3) --}}
    <div class="rew_prfl_sectin">
      <div class="prfl_img">
        @if($item->user_image)
        <img src="{{asset('assets/images/profiles')}}/{{  $item->user_image }}">
        @else
        <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
        @endif
      </div>
      <div class="rate_date">
        <div class="title_star">
          <h6>{{@$item->user_name}}</h6>
          <div class="gray_star">
            <div class="orng_star" style="width: {{(@$item->rate) * 100 / 5}}%;"></div>
          </div>
        </div>
        <div class="date_frmt">
          <span>{{@\Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</span>
        </div>
      </div>
      <p>{{@$item->body}}</p>
    </div>
    {{-- @endif --}}
    @php $reviewCount++; @endphp
    @endforeach
    @endif
    @endif
    @endforeach
  </div>
</div>
@endforeach
@else
<div class="col-md-12">
  <p>@lang('filter.no_library_available') !!</p>
  <div class="clearfix"></div>
  <br/>
  <div class="clearfix"></div>
  <br/>
</div>
@endif