        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" >

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
                            if (strlen($user->badgeimageurl) >0 && File::exists(public_path()."\assets\images\profiles\\".$user->user_image)) {$uimg= $user->user_image;}
                        else{$uimg= '/default.png';}
                        @endphp
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="invitelearner{{$user->id}}" >
                        <div  class="col-xl-7 col-lg-7 col-sm-7 col-xs-7 all-padding  " >

                                <img src="{{asset('assets/images/profiles/').$uimg}}" width="25" height="25" vspace="4" hspace="4" align="middle">

                            {{$user->name}}</div>
                        <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-3 all-padding " style="line-height: 33px"></div>
                        <div  class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 all-padding"  style="line-height: 33px"> <input type="button" class="btn btn-edubtn invitelearner" data-edit-link="{{ route('CourseclassesController.classlearner.invitelearner',$courseclass->id) }}" value="Invite" id="add{{$user->id}}" onclick="invitelearner({{$user->id}})">
                        </div></div>
            @endforeach
                @endif



            </form>

        </div>



