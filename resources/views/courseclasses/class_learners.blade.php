<div class="main_summery_earth pd_lf_25">
        <div class="name_list mrgn-bt-30 mrgn-tp-0">
            <h4>{{ $courseclass->class_name }}</h4>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <h4 class="exersc_title mrgn-bt-20">@lang('classcourse.learners')</h4>
                <button type="button" data-toggle="modal" data-target="#invite_model" data-dismiss="modal" class="creat_new btn pdng_add_btn">@lang('classcourse.invite')</button>
            </div>
            <div class="col-sm-5 text-right">
                <div class="form-group serch_section">
                    <span class="form-control-serch"></span>
                    <input type="search" class="form-control" id="search" placeholder="@lang('messages.search')">
                </div>
            </div>
        </div>
        <div class="list_of_Collabrators mrgn-tp-20">
            <div class="row">
                @if($courseclass->learners()->count() > 0)
                    <div class="col-lg-12 col-xl-7">
                        <div class="collarbl_table new_tble_clbr width_redus border-right table-responsive">
                            <table class="table" cellpadding="0" cellspacing="0">
                                <tbody id="classlearner_id">
                                @foreach($courseclass->learners()->get() as $learner)
                                    @if(  $learner->pivot->status != 'Pending')
                                    @php
                                        $learner->courseclass_id = $courseclass->id;
                                    @endphp
                                    {{-- <div id="classlearner_id{{$learner->pivot->id}}"> --}}
                                        @include('courseclasses.learner',$learner)
                                        {{-- <tr id="remove_{{$learner->id}}" >
                                            <td>
                                                <div class="stdnt_nme">
                                                    @php
                                                    if (strlen($learner->user_image) >0 && File::exists(public_path()."\assets\images\profiles\\".$learner->user_image)) {$uimg= $learner->user_image;}
                                                    else{$uimg= '/default.png';}
                                                    @endphp
                                                    <img src="{{asset('assets/images/profiles/').$uimg}}">
                                                    <span class="name">{{$learner->name}}</span>
                                                </div>
                                            </td>
                                            <td>{{$learner->email}}</td>
                                            <td class="date"> {{date('d/m/y', strtotime($learner->pivot->joindate) )}}</td>
                                            <td>
                                                <span class="done_text">
                                                    {{$learner->pivot->status}}
                                                </span>
                                            </td>
                                            <td><span class="delete_icn_bg" id="lerner_{{$learner->id}}" data-lerner-id="{{$learner->id}}" data-class-id="{{$courseclass->id}}" onclick="removeFromClass(this.id)"></span></td>
                                        </tr> --}}
                                    </div>
                                    @endif
                                @endforeach
                                </tr>
                                {{-- <tr>
                                    <td>
                                        <div class="stdnt_nme">
                                            <img src="image/co_pr3.png">
                                            <span class="name"> Scott Davis</span>
                                        </div>
                                    </td>
                                    <td>ScottDavis-87@example.com</td>
                                    <td class="date">23/06/2018</td>
                                    <td><span class="done_text">Enrolled</span></td>
                                    <td><a href="#" class="delete_icn_bg"></a></td>
                                </tr> --}}                          
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-5">
                        <div class="collarbl_table new_tble_clbr requestd_tble table-responsive">
                            @php
                                $count = 0;
                                foreach($courseclass->learners()->get() as $learner){
                                    if(  $learner->pivot->status =='Pending'){
                                        $count = 1;
                                    }
                                }
                            @endphp
                            @if($count === 1)
                            <h5 id="requestLabel">@lang('classcourse.requests')</h5>
                            <table class="table" cellpadding="0" cellspacing="0" id="requestTable">
                                <tbody>
                                @foreach($courseclass->learners()->get() as $learner)
                                    @if(  $learner->pivot->status=='Pending')
                                    <tr id="request_{{$learner->pivot->id}}">
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
                                        <td>
                                            <div class="request_cls">
                                                <button type="button" class="accept-request"  title="@lang('messages.Accept')"  onclick="accept_reject_learner( '{{ route('courseclasses.courseclass.accept', $learner->pivot->id) }}','{!! $learner->pivot->id !!}')"></button>
                                                <button type="button"class="cancel-request" title="@lang('messages.Reject')"  onclick="accept_reject_learner( '{{ route('courseclasses.courseclass.reject', $learner->pivot->id) }}','{!! $learner->pivot->id !!}')"></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                {{-- <tr>
                                    <td>
                                        <div class="stdnt_nme">
                                            <img src="image/co_pr3.png">
                                            <span class="name"> Scott Davis</span>
                                        </div>
                                    </td>
                                    <td>ScottDavis-87@example.com</td>
                                    <td>
                                        <div class="request_cls">
                                            <button type="button"class="accept-request"></button>
                                            <button type="button" class="cancel-request"></button>
                                        </div>
                                    </td>
                                </tr> --}}
                                </tbody>
                            </table>
                            @else
                                {{--  <p>No Learners Available !!</p>  --}}
                            @endif
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 col-xl-7">
                        <p>@lang('classcourse.no_learners_available')</p>
                    </div>
                @endif
            </div>
        </div>
    </div>