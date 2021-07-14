<div class="rating_view_detail">
        @if (count($ratings) > 0)
        @foreach($ratings as $ratekey => $item)
        <div class="rew_prfl_sectin after_{{$ratekey}}">
           <div class="prfl_img">
               @if ($item->reviewrateable_type == 'App\Models\Courseclass')     
                  <img src="{{asset('assets/images/')}}/{{  $item['ratings_data']['image'] }}">
               @elseif ($item->reviewrateable_type == 'App\Models\Game')
                  <img src="{{ asset('assets/eduplaycloud/image/game_8.png') }}"/>
               @elseif ($item->reviewrateable_type == 'App\Models\Exerciseset')
                  <img src="{{ asset('uploads/exercisesets/')}}/{{  $item['ratings_data']['image'] }}"/>
               @endif
           </div>
           <div class="rate_date">
              <div class="title_star">
              <h6>
                  @if ($item->reviewrateable_type == 'App\Models\Game') 
                      <a style='color: inherit !important;' href="{{ route('games.game.show',$item['ratings_data']['id'])}}">{{@$item['ratings_data']['name']}}</a>
                  @elseif ($item->reviewrateable_type == 'App\Models\Courseclass') 
                      <a style='color: inherit !important;' href="{{ route('courseclasses.courseclass.show',$item['ratings_data']['id'])}}">{{@$item['ratings_data']['name']}}</a>
                  @elseif ($item->reviewrateable_type == 'App\Models\Exerciseset') 
                      <a style='color: inherit !important;' href="{{ route('exercisesets.exerciseset.show',array($item['ratings_data']['id'],1)) }}">{{@$item['ratings_data']['name']}}</a>
                  @endif
                  
              </h6>
                 <div class="gray_star">
                    <div class="orng_star" style="width: {{(@$item['ratings_data']['rate']) * 100 / 5}}%;"></div>
                 </div>
              </div>
              <div class="date_frmt">
                 <span>{{@\Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</span>
              </div>
           </div>
           <p>{{@$item->body}}</p>
        </div>
        @endforeach
        @else
          <div id="no_records">
            @lang('messages.no_more_reviews')
          </div>
           
        @endif
     </div>