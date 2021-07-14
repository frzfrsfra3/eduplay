<!--Share By Mail Model-->
<div class="modal fade default_modal wht_bg_mdl" id="share_mail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exercisesets.mail')</h3>
                            <form class="def_form" action="{{route('mail.exerciseset')}}" id="share_email_form" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" id="url" name="url" value=""  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('exercisesets.enter_email'): </label>
                                   <input type="email" id="email" name="email" value=""  class="form-control" required>
                                </div>
                                <div class="form-group mrgn-tp-30">
                                    <button type="submit" class="btn btn-primary btn-login drk_bg_btn">@lang('exercisesets.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($exercisesets))
    @foreach($exercisesets as $key => $exerciseset)
    <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
        <div class="main_info">

            @auth
            <button type="button" data-exerciseset="{{route('practice.index', [ $exerciseset->id ])}}"
                id="share_{{$exerciseset->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private"
                data-toggle="tooltip" title="@lang('exercisesets.share')"
                class="share_link_icn"
                style="
                position: absolute;
                top: 10px;
                right: 77px;
                z-index: 100000;
                ">
            </button>
            @endauth

            <a href="{{route('exercisesets.exerciseset.summary', [ $exerciseset->id  ,$ispublic])}}" class="info_exercise">
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
                {{--  <img src="{{asset('assets/eduplaycloud/image/public_libray.png')}}" class="img-fluid">  --}}
                @if ($class_id != null)
                    <div class="whit_checbx">
                        <div class="profile_name">
                                @if(isset($exerciseset->owner->user_image))
                                    @if (file_exists( public_path() . '/assets/images/profiles/' . $exerciseset->owner->user_image))
                                        <img src="{{asset('assets/images/profiles')}}{{  '/'.$exerciseset->owner->user_image }}">
                                    @else
                                        <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                                    @endif
                                @else
                                    <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                                @endif
                                <p>{{ optional($exerciseset->owner)->name }}</p>
                            </div>
                        </div>
                        <div class="main_shr">
                        <div class="custom-control checkbox custom-checkbox chbx_wt">
                            @if (Auth::user()->hasRole('Teacher'))
                                <input name="exerses[]" value="{{$exerciseset->id}}" id="exerses_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="exerses_{{$exerciseset->id}}"></label>
                            @endif
                        </div>
                    </div>
                @else
                <div class="whit_checbx">
                    <div class="profile_name">
                        @if(isset($exerciseset->owner->user_image))
                            @if (file_exists( public_path() . '/assets/images/profiles/' . $exerciseset->owner->user_image))
                                <img src="{{asset('assets/images/profiles')}}{{  '/'.$exerciseset->owner->user_image }}">
                            @else
                            <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                            @endif
                        @else
                            <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                        @endif
                        <p>{{ optional($exerciseset->owner)->name }}</p>
                    </div>
                </div>
                    <div class="main_shr add_clrbl">
                        <div class="request_add float-right">
                         @if(!Auth::guest())
                            @if ($exerciseset->price != 0)
                                <button type="button" class="collbr_btn icon_by">@lang('explore.Buy')</button>
                            @else
                                @if(count($exerciseset->buyers))
                                <button type="button" class="collbr_btn icon_approvd">@lang('explore.Added')</button>
                                @else
                                <button type="button" class="collbr_btn icon_clrbl">@lang('explore.Add')</button>
                                @endif
                            @endif
                          @endif
                        </div>
                    </div>
                @endif

                <div class="left_time_info">
                    <ul class="time_info float-left">
                        <li>

                            @if ($exerciseset->price != 0)
                                ${{ $exerciseset->price }}
                            @else
                                @lang('explore.FREE')
                            @endif
                        </li>
                        <li class="time_icn">{{  gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }}</li>
                    </ul>
                    <ul class="skill_info float-right">
                        <li>@lang('messages.skills') : {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}</li>
                        <li>@lang('messages.questions') : {{  $exerciseset->question->count() }}</li>
                    </ul>
                </div>
            </a>
            <div class="main_shr add_clrbl">

              <div class="request_add float-right">
                @guest
                  <button type="button" data-toggle="modal" data-target="#login_btn" class="collbr_btn icon_clrbl">@lang('explore.Add')</button>
                @endguest
              </div>
            </div>
            <ul class="title_cmbo">
                <li><a href="javascript:;">{{str_limit(@$exerciseset->title, '20')}}</a></li>
                @if($exerciseset->discipline)
                <li><p>{{@$exerciseset->discipline->discipline_name}}</p></li>
                @else
                    <li><span>@lang('filter.n/a')</span></li>
                @endif
                <li><p>{{str_limit(@$exerciseset->topics->topic_name, '10')}}</p></li>
            </ul>
            <ul class="star_wth_user">
                <li>
                    <div class="gray_star">
                        <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                    </div>
                    <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                </li>
                @if($exerciseset->grade)
                    <li title="{{$exerciseset->grade->grade_name}}"><span>{{ str_limit($exerciseset->grade->grade_name , '18') }}</span></li>
                @else
                    <li><span>@lang('filter.n/a')</span></li>
                @endif
                <li><small>{{ $exerciseset->created_at }}</small></li>
                <li><small>{{ $exerciseset->language->language }}</small></li>
            </ul>
            <div class="descption_prfl">
                <p>{{ strlen($exerciseset->description) > 153 ? substr($exerciseset->description,0,150)."..." : $exerciseset->description }}</p>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-12 cstm-pgntn">
        <nav aria-label="Page navigation example" class="float-right">
            {{ $exercisesets->links() }}
        </nav>
    </div>
@else
    <div class="col-md-12">
        <p>@lang('messages.no_library_available') !!</p>
    </div>
@endif
<script>

    $('body li #exploreMenu').addClass('active');

    //Email send in exersice id get.
   function generateEmailUrl(id){
       $('#url').val($('#'+id).attr('data-exerciseset'));
       $('#share_mail').modal('show');
   }

   //Develop by WC
   $("#share_email_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {

        }
    });


</script>
