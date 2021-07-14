<div class="list_of_exercise mrgn-tp-20">
    <div class="row" id="pinsFilter">
        @if(count($pins) >0)
            @foreach($pins as $pin)
                <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                    <div class="main_info">
                        <a href="{{ $pin->url }}" class="info_exercise" target="_blank">

                            @if(isset($courseclass))
                                @if(isset($pin->image) && !empty($pin->image))
                                    @if (strlen($pin->image) > 0 && File::exists(public_path()."/assets/eduplaycloud/users-".$courseclass->teacher_userid."/pins/".$pin->image))
                                        <img src="{{ asset('assets/eduplaycloud/users-'.$courseclass->teacher_userid.'/pins') }}/{{  $pin->image }}" alt="{{ $pin->image }}">
                                    @else
                                        <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                                    @endif
                                @else
                                    <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                                @endif
                            @else
                                @if(isset($pin->image) && !empty($pin->image))
                                    @if (strlen($pin->image) > 0 && File::exists(public_path()."/assets/eduplaycloud/users-".$user['id']."/pins/".$pin->image))
                                        <img src="{{ asset('assets/eduplaycloud/users-'.$user['id'].'/pins') }}/{{  $pin->image }}" alt="{{ $pin->image }}">
                                    @else
                                        <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                                    @endif
                                @else
                                    <img src="{{ asset('assets/eduplaycloud/image/pins_bg.png') }}" class="img-fluid">
                                @endif
                            @endif
                        </a>
                        @php
                            $url=Request::segment(1).'/'.Request::segment(2);
                        @endphp
                        @if ($url == 'exercisesets/private')
                        <div class="whit_checbx">
                            <div class="custom-control checkbox custom-checkbox chbx_wt">
                                @if (Auth::user()->hasRole('Teacher'))
                                    <input name="pin[]" value="{{$pin->id}}" id="pin_{{$pin->id}}" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="pin_{{$pin->id}}"></label>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="pins_info">
                            <p>{{ str_limit($pin->description, '18')}}</p>
                        </div>
                        @if(isset($courseclass))
                            @if(Auth::user()->id == $courseclass->teacher_userid)
                            <ul class="editable_list">
                                <li><a class="edit_wt_icn"  onclick="editPin({{$pin->id}})" href="javascript:;">Edit</a></li>
                                <li><a class="delet_wt_icn" href="javascript:;" onclick="deletePin({{$pin->id}})">Delete</a></li>
                            </ul>
                            @endif
                        @else
                            <ul class="editable_list">
                                <li><a class="edit_wt_icn"  onclick="editPin({{$pin->id}})" href="javascript:;">Edit</a></li>
                                <li><a class="delet_wt_icn" href="javascript:;" onclick="deletePin({{$pin->id}})">Delete</a></li>
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                <p>@lang('messages.no_data_found')</p>
            </div>
        @endif
    </div>
</div>
{{-- <div class="col-md-12 cstm-pgntn">
    <nav aria-label="Page navigation example" class="float-right">
        {{ $pins->links() }}
    </nav>
</div> --}}