 <div class="clearfix"></div>
    <div class="name_list mrgn-bt-30">
        <h4>{{ $googleclass->name }}</h4>
    </div>
<div class="row">
    <div class="col-sm-7">
        {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#invite_model" data-dismiss="modal" class="creat_new pdng_add_btn">Invite</a> --}}
    </div>
    {{-- <div class="col-sm-5 text-right">
        <div class="form-group serch_section">
            <span class="form-control-serch"></span>
            <input type="search" class="form-control" placeholder="Search">
        </div>
    </div> --}}
</div>
<div class="list_of_Collabrators mrgn-tp-20">
    <div class="row">
        <div class="col-lg-12 col-xl-7">
            <div class="collarbl_table new_tble_clbr width_redus border-right table-responsive">
                <table class="table" cellpadding="0" cellspacing="0"> 
                    <tbody>
                    @foreach($googleclass->learners()->get() as $learner)
                    <tr id="remove_{{$learner->id}}">
                        <td>
                            <div class="stdnt_nme">
                              @if(isset($learner->user_image) && !empty($learner->user_image))
                                  @if (strlen($learner->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$learner->user_image))
                                      <img  src="{{ asset('assets/images/profiles') }}/{{  $learner->user_image }}" alt="{{$learner->name }}">
                                  @else
                                      <img  src="{{  $learner->user_image }}" alt="{{$learner->name }}">
                                  @endif
                              @else
                                  <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{$learner->name }}">
                              @endif
                              <span class="name">{{$learner->name}}</span>
                          </div>
                        </td>
                        <td>{{$learner->email}}</td>
                        <td class="date"> {{date('d/m/y', strtotime($learner->pivot->joindate) )}}</td>
                        <td><span class="done_text">{{ $learner->pivot->status }}</span></td>
                        <td><span class="delete_icn_bg pointer" title="@lang('messages.delete')" id="lerner_{{$learner->id}}" data-lerner-id="{{$learner->id}}" data-class-id="{{$learner->pivot->googleclassid}}" onclick="removeFromClass(this.id,this.getAttribute('data-class-id'))"></span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5">
            <div class="collarbl_table new_tble_clbr requestd_tble table-responsive">
                <h5>Google classroom studens</h5>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tbody id="students-tbody">
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>