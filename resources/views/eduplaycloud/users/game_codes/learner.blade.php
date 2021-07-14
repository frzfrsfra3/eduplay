<form method="POST" action="" accept-charset="UTF-8" class="form-horizontal">
    {{ csrf_field() }}

 @if($users)
    @foreach($users as $user)
        @php
            if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image)) {
                $uimg= asset('assets/images/profiles').'/'.$user->user_image;
                $style = 'border-radius: 50%;';
            } else {
                $uimg= asset('uploads/profile').'/proflie_welcome.png';
                $style = '';
            }
        @endphp
        <div class="both_inviter" id="invitelearner{{$user->id}}" >
            <div  class="left_invitr_name" >
                <div class="user_img">
                <img src="{{ $uimg }}" vspace="4" style="{{ $style }}" hspace="4" align="middle">
                    <span>{{$user->name}} - {{$user->email}}</span>
                    </div>
                </div>
            <div  class="right_inviter" >
                <button type="button" class="btn btn-primary btn-login" data-code="{{$code}}" data-email="{{$user->email}}" onclick="shareCodeToLearner(this)">@lang('messages.share')</button>
            </div>
        </div>
    @endforeach
@endif
</form>