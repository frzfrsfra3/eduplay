<tr id="remove_{{$learner->id}}" >
    <td>
        <div class="stdnt_nme">
            @if(isset($learner->user_image) && !empty($learner->user_image))
                @if (strlen($learner->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$learner->user_image))
                    <img  src="{{ asset('assets/images/profiles') }}/{{  $learner->user_image }}" alt="{{$learner->name }}">
                @else
                    <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{$learner->name }}">
                @endif
            @else
                <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{$learner->name }}">
            @endif
            <span class="name">{{$learner->name}}</span>
        </div>
    </td>
    <td>{{$learner->email}}</td>
    <td class="date"> {{date('d/m/y', strtotime($learner->pivot->joindate) )}}</td>
    <td>
        <span style=" {{ $learner->pivot->status =='Rejected' ? 'color:#ff0000 !important;' : '' }} {{ $learner->pivot->status =='Invited' ? 'color:#ff9028 !important;' : '' }}" class="{{ $learner->pivot->status =='Rejected' ? 'reject_text' : 'done_text' }}">
            @if ($learner->pivot->status == 'Rejected')
                @lang('messages.rejected')
            @elseif ($learner->pivot->status == 'Invited')
                @lang('messages.invited')
            @elseif ($learner->pivot->status == 'Accepted')
                @lang('messages.accepted')
            @elseif ($learner->pivot->status == 'Requested')
                @lang('messages.requested')
            @else 
                {{ $learner->pivot->status }}
            @endif
        </span>
    </td>
    <td><span class="delete_icn_bg pointer" title="@lang('messages.delete')" id="lerner_{{$learner->id}}" data-lerner-id="{{$learner->id}}" data-class-id="{{$learner->courseclass_id}}" onclick="removeFromClass(this.id,this.getAttribute('data-class-id'))"></span></td>
</tr>

