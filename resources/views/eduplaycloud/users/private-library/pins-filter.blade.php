@if(count($pins) >0)
    @foreach($pins as $pin)
        <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
            <div class="main_info">
                <a href="{{ $pin->url }}" class="info_exercise" target="_blank">
                    @if(isset($pin->image) && !empty($pin->image))
                        @if (strlen($pin->image) > 0 && File::exists(public_path()."/assets/eduplaycloud/users-".$user['id']."/pins/".$pin->image))
                            <img src="{{ asset('assets/eduplaycloud/users-'.$user['id'].'/pins') }}/{{  $pin->image }}" alt="{{ $pin->image }}">
                        @else
                            <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                        @endif
                    @else
                        <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                    @endif
                </a>
                <div class="pins_info">
                    <p>{{  str_limit($pin->description, '18') }}</p>
                </div>
                <ul class="editable_list">
                    <li><a class="edit_wt_icn"  onclick="editPin({{$pin->id}})" href="javascript:;">Edit</a></li>
                    <li><a class="delet_wt_icn" href="javascript:;" onclick="deletePin({{$pin->id}})">Delete</a></li>
                </ul>
            </div>
        </div>
    @endforeach
@else
    <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
        <p>No Pins Available !!</p>
    </div>
@endif