@if(count($games))
    @foreach($games as $game)
    <li>
        <a href="{{ route('games.game.show',$game->id) }}">
        {{-- <a href="#"> --}} 
            @php
            if (isset($game->game_icon) && !empty($game->game_icon)) {
                if (strlen($game->game_icon) > 0 && File::exists(public_path()."/uploads/games/".$game->game_icon)) {
                    $gameImage = '/uploads/games/'.$game->game_icon;                    
                } else {
                    $gameImage = 'assets/eduplaycloud/image/game_1.png';
                }
            } else {
                $gameImage = 'assets/eduplaycloud/image/game_1.png';
            }
            @endphp
            <img src="{{ asset($gameImage) }}" class="img-fluid">
            <h6>{{ $game->game_name }}</h6>
            <p>{{ $game->game_name }}</p>
            <ul class="star_wth_user text-ar-right">
                <li>
                  <div class="gray_star">
                      <div class="orng_star" style="width: {{(@$game->averageRating(1)[0]) * 100 / 5}}%;"></div>
                  </div>
                </li>
            </ul>
        </a>
    </li>
    @endforeach
@else 
<li><div class="col-md-12"><p>@lang('games.no_games_found')</p></div></li>
@endif