<div class="tab-pane fade" id="pills-avtar" role="tabpanel" aria-labelledby="pills-avatar-tab">
    <div class="inner_level_badgets mrgn-bt-60">
        <h5 class="level_title mrgn-bt-50">@lang('profile.select_your_avatar')</h5>
        <ul class="select_avatar badget_earned">
            @if(count($avatarList) > 0)
                @foreach ($avatarList as $value)
                    <li>
                        @if ($userTotalPoints >= $value->points)
                            <a href="javascript:;" onclick="avatarDetails({{ $value->id }})"  class="restl_cls point_earn pink">
                                <img src="{{ asset('assets/eduplaycloud/image/'.$value->image) }}" alt="" class="img-fluid">
                                <h4>{{ $value->name }}</h4>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="restl_cls point_earn pink">
                                <div class="list_lc loack_avtar"><i></i></div>
                                <img src="{{ asset('assets/eduplaycloud/image/'.$value->image) }}" alt="" class="img-fluid">
                                <h4>{{ $value->name }}</h4>
                            </a>
                        @endif
                    </li>
                @endforeach
            @else
                <div class="col-lg-12">
                    <P>@lang('messages.no_data_found')!</P>
                </div>
            @endif
            <div class="clearfix"></div>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>