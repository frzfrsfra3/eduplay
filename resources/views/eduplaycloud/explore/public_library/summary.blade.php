@extends('authenticated.layouts.default')
@section('header_styles')
<link href="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.css')}}" />
@stop
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="mrgn-tp-30 text-ar-right">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            @if( str_replace(url('/'), '', url()->previous()) == '/exercisesets/private')
                                <a href="{{route('exercisesets.exerciseset.private')}}">@lang('exerciseset_show.my_private_exercise')</a>
                            @else
                                <a href="{{route('explore.exerciseset')}}">@lang('exerciseset_show.public_library')</a></li>
                            @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $exerciseset->title }}</li>
                    </ol>
                </nav>
                <div class="clearfix"></div>
                <div class="main_summery_earth">
                <div class="earth_publish mrgn-tp-20 mrgn-bt-10">
                    <div class="name_list float-left">
                        <h4>{{ $exerciseset->title }}</h4>
                    </div>
                    <div class="publist_list float-right">
                        @if (Auth::guest () && $exerciseset->price==0)
                        <!--<a href="javascript:;" data-url="{{ route('exercisesets.exerciseset.addtomylibrary', $exerciseset->id ) }}"
                            id="addtomylibrary" onclick="addtomylibrary()" class="add_btn add_privt_lbr_btn">@lang('exerciseset_show.add_to_private_lib')</a>
                        -->
                        @endif
                        @auth
                            @if($exerciseset->createdby != Auth::User()->id)
                                @if ($addtoprivatelibrary == false) 
                                    <a href="javascript:;" data-url="{{ route('exercisesets.exerciseset.addtomylibrary', $exerciseset->id ) }}"
                                        id="addtomylibrary" onclick="addtomylibrary()" class="add_btn add_privt_lbr_btn">@lang('exerciseset_show.add_to_private_lib')
                                    </a>
                                @else 
                                    <a href="{{ route('practice.index', $exerciseset->id ) }}" class="practice_btn m2 m-1" title="@lang('exerciseset_show.practice_exerciseset')" >
                                        @lang('exerciseset_show.practice')
                                    </a>
                                    <a href="{{ route('exercisesets.exerciseset.removefrommylibrary', $exerciseset->id ) }}" class="practice_btn m2" title="@lang('exerciseset_show.practice_exerciseset')" >
                                        Remove 
                                    </a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
                 <div class="clearfix"></div>
                 <div class="summery_title">
                    <h3>@lang('exerciseset_show.summary')</h3>
                 </div>
                <div class="row">
                    <div class="col-lg-5 col-xl-4">
                       <div class="inner_summery">
                           <ul class="star_wth_user medium_star_user">
                               <li>
                                   <div class="gray_star">
                                       <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                   </div>
                                   <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                               </li>
                           </ul>
                           <ul class="excersie_list practice_list blue-clr-ln">
                               <li><span>
                                    @if ($exerciseset->price != 0)
                                        ${{ $exerciseset->price }}
                                    @else
                                        @lang('exerciseset_show.free')
                                    @endif
                                </span></li>
                               <li><span>{{gmdate("H:i:s",$exerciseset->question->sum('maxtime'))}}</span></li>
                               <li>@lang('exerciseset_show.skills') : <span>{{($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id'))}}</span></li>
                               <li>@lang('exerciseset_show.questions') : <span>{{$exerciseset->question->count()}}</span></li>
                           </ul>
                           <ul class="excersie_list practice_list">
                                <li>@lang('exerciseset_show.status') :<span> {{ucfirst($exerciseset->publish_status) }}</span></li>
                                <li>@lang('exerciseset_show.updated') :<span>{{$exerciseset->updated_at}}</span></li>
                           </ul>
                           <ul class="excersie_list practice_list">
                               <li>@lang('exerciseset_show.discipline_curriculum')  :<span> {{ optional($exerciseset->discipline)->discipline_name }} </span></li>
                           </ul>
                           <ul class="excersie_list practice_list">
                               <li>@lang('exerciseset_show.language') :<span> {{ optional($exerciseset->language)->language }}</span></li>
                           </ul>
                       </div>
                    </div>
                    <div class="col-lg-7 col-xl-8">
                      <div class="about_teacher_block">
                          <h3>@lang('exerciseset_show.about_teacher')</h3>
                          <div class="techer_detail">
                                @if (file_exists( public_path() . '/assets/images/profiles/' . $exerciseset->owner->user_image))
                                @if($exerciseset->owner->user_image)
                                    <img src="{{asset('assets/images/profiles')}}/{{  $exerciseset->owner->user_image }}">
                                @else
                                    <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                                @endif
                                @else
                                    <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                                @endif
                              <h4>{{ ($exerciseset->owner)->name }}</h4>
                              <p>{{ ($exerciseset->owner)->aboutme }}</p>
                          </div>
                      </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="discription_block mrgn-tp-20 mrgn-bt-20">
                                <h4>@lang('exerciseset_show.about_exercise_set')</h4>
                                <p>{{ $exerciseset->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="review_section">
                                <div class="row">
                                    <div class="col-md-8 col-xl-11">
                                        <div class="inner_review_section">
                                            <h3>@lang('exerciseset_show.reviews_and_ratings')</h3>
                                            <div class="row">
                                                <div class="col-lg-5 col-xl-4">
                                                    <ul class="star_wth_user big_star_user">
                                                        <li>
                                                            <div class="gray_star">
                                                                <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                            </div>
                                                            <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                                                        </li>
                                                    </ul>
                                                    <div class="rating_graph mrgn-tp-20">
                                                        <div class="row_rating">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <div class="rtng_bbx">
                                                                <div class="side">
                                                                    <div>{{$i}}</div>
                                                                </div>
                                                                <div class="middle">
                                                                    <div class="bar-container">
                                                                        @php $total = 0; 
                                                                            foreach($userrate as $ratekey => $item) {
                                                                                if($item->rate == $i)
                                                                                    $total += 1;
                                                                            }
                                                                            $avg = 0;
                                                                            if(count($userrate))
                                                                                $avg = (@$total) * 100 / count(@$userrate)
                                                                        @endphp
                                                                        <div class="bar-{{$i}}" style="width: {{$avg}}%;"></div>
                                                                    </div>
                                                                    <small class="pull-right" style="color:blue;">{{$total}}</small>
                                                                </div>                                                                   
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xl-8">
                                                  <div class="rating_view_detail">
                                                    @foreach($userrate as $ratekey => $item)
                                                        <div class="rew_prfl_sectin after_{{$ratekey}}">
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
                                                    @endforeach
                                                        <div class="rew_prfl_sectin view_more">
                                                            <a href="javascript:;" id="view_more_link" class="view_more_btn">@lang('exerciseset_show.view_more')</a>
                                                            <a href="javascript:;" id="view_less_link" class="view_more_btn" style="display:none;">@lang('exerciseset_show.view_less')</a>
                                                        </div>

                                                        @auth
                                                        <div class="write_review mrgn-tp-20">
                                                            <div class="accordion write_accordion" id="accordionExample">
                                                              <div class="card">
                                                                    <button class="btn btn-link write_rivw_bnt" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        @lang('exerciseset_show.write_a_review')
                                                                    </button>
                                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                        <div class="card-body">
                                                                            <form class="def_form riew_frm" id="review_form" method="POST">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <div class="text-right text-ar-left posted_list">
                                                                                        <a href="#">@lang('exerciseset_show.posted_as') {{Auth::user()->name}} </a>
                                                                                        <a href="javascript:;" id="clear_review">@lang('exerciseset_show.clear')</a>
                                                                                    </div>
                                                                                    <input type="hidden" name="id" id="exerciseset_id" value="{{$exerciseset->id}}">
                                                                                    <textarea class="form-control" name="comment" id="comment" placeholder="@lang('exerciseset_show.write_a_review')"></textarea>
                                                                                </div>
                                                                                <ul class="star_wth_user">
                                                                                    <li>
                                                                                        <div id="give_rate"></div>
                                                                                        <span class="rtng blue-clr">@lang('exerciseset_show.overall_rating')</span>
                                                                                        <div id="rating_err" style="color: crimson !important;font-size: 14px;">

                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="submit_btn" id="submit_review">@lang('exerciseset_show.submit')</button>
                                                                                    <button type="button" class="cancel-gry-btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">@lang('exerciseset_show.cancel')</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.js')}}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
var numItems = 0;
$(document).ready(function()
{
    $('body li #homeMenu').removeClass('active');
    numItems = $('.rew_prfl_sectin').nextUntil('.view_more').length;

    if(numItems >= 3) {
        $('div.after_1').nextUntil('.view_more').hide();
    }
    else {
        $('#view_more_link').hide();
    }
});

$('#view_more_link').click(function()
{
    if(numItems >= 3)
    {
        $('div.after_1').nextAll().show();
        $(this).hide();
        $('#view_less_link').show();
    }
});

$('#view_less_link').click(function()
{
    if(numItems >= 3)
    {
        $('div.after_1').nextUntil('.view_more').hide();
        $(this).hide();
        $('#view_more_link').show();
    }
});

$('#give_rate').on('click',function() {
    $('#rating_err').html('');
});

$('#give_rate').raty({
    starOff: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-off.png')}}",
    starOn: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-on.png')}}",
    hints: ['@lang("messages.bad")', '@lang("messages.poor")', '@lang("messages.regular")', '@lang("messages.good")', '@lang("messages.gorgeous")'],
});

$("#submit_review").click( function()
{
    $.ajax({
        url: "{{route('exercisesets.exerciseset.addreview')}}",
        type: "post",
        dataType: 'json',
        data: $('#review_form').serialize(),
        success: function(response){ // What to do if we succeed
            if (response == 'fail') {
                $('#rating_err').html('@lang("exercisesets.select_rating")');
            }
            if(response == 'success')
                location.reload();
        },
        error: function(response){
            
        }
    });
});

$('#clear_review').click(function()
{
    $('#comment').val('');
    $('#give_rate').raty('reload'); 
});

function addtomylibrary()
{
    swal({
    title: "@lang('messages.are_you_sure')",
    text: "@lang('messages.add_my_private_library')",
    icon: "warning",
    buttons: {
        cancel: {
            visible : true,
            text : '@lang("messages.cancel")'
        },
        confirm: {
            visible : true,
            text : '@lang("messages.ok")'
        },
    },
    dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            var url=$('#addtomylibrary').data("url");
            @auth()
            $.ajax({
                type: "post",
                dataType: "text",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    swal("@lang('messages.you_can_practice_now')", {
                        icon: "success",
                        button : {
                            text : '@lang("messages.ok")'
                        }

                    }).then((reload) => {
                        location.reload();
                        
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                //   console.log("AJAX error : " + JSON.stringify(err, null, 2));
                    // console.log('jqXHR:');
                    // console.log(jqXHR);
                    // console.log('textStatus:');
                    // console.log(textStatus);
                    // console.log('errorThrown:');
                    // console.log(errorThrown);
                }
            });
        }
    });
    @endauth
    @guest()
        
        location.href='{{route('login')}}';
    @endguest
}
</script>
@endpush