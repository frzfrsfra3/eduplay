@if (count($userrate) > 0)
    @foreach($userrate as $ratekey => $item)
        <div class="rew_prfl_sectin after_{{$ratekey}}">
            <div class="prfl_img">
                
                @if($item->author['user_image'])
                <img src="{{asset('assets/images/profiles')}}/{{  $item->author['user_image'] }}">
                @else
                <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
                @endif
            </div>
            <div class="rate_date">
                <div class="title_star">
                    <h6>{{@$item->author['name']}}</h6>
                    <div class="gray_star">
                        <div class="orng_star" style="width: {{(@$item['rating']) * 100 / 5}}%;"></div>
                    </div>
                </div>
                <div class="date_frmt">
                    <span>{{@\Carbon\Carbon::parse($item['created_at'])->format('M d, Y')}}</span>
                </div>
            </div>
            <p>{{@$item['body']}}</p>
        </div>
    @endforeach
@else
    <div id="no_records">
      @lang('messages.no_more_reviews')
    </div>     
@endif