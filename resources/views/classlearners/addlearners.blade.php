<div class="all_list_invite" >
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('classlearners.classlearner.savelist' ,$courseclass->id) }}" accept-charset="UTF-8" id="create_classlearner_form" name="create_classlearner_form" class="form-horizontal">
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
                    <input type="button" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" class="btn btn-edubtn invitelearner" data-edit-link="{{ route('CourseclassesController.classlearner.invitelearner',$courseclass->id) }}" value="@lang('classcourse.send_request')" id="add{{$user->id}}" onclick="invitelearner({{$user->id}})">
                </div>
            </div>
        @endforeach
    @endif

</form>
<div class="clearfix"></div>
</div>



