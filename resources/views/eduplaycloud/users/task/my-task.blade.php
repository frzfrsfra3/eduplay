@extends('authenticated.layouts.default')
@section('content')
<div class="pg-content text-ar-right">
        <div class="inner_profile_pdng">
        <div class="row">
            <div class="col-md-7 orng_bg_trnprnt">
                <div class="welcom_proflie">
                  <h4>@lang('home.welcome_to_edu')</h4>
                    <p>@lang('home.play_learn')</p>
                    <div class="prgress-tp">
                    <div class="progress" data-percentage="40">
                    <span class="progress-left">
                        <span class="progress-bar"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar"></span>
                    </span>
                        <div class="progress-value">
                            <div class="img-prgres">
                                @php
                                if (isset($user->user_image) && !empty($user->user_image)) {
                                    if (strlen($user->user_image) > 0 && File::exists(public_path()."/uploads/profile/".$user->user_image)) {
                                        $userImage = $user->user_image;
                                    } else {
                                        $userImage = 'proflie_welcome.png';
                                    }
                                } else {
                                    $userImage = 'proflie_welcome.png';
                                }
                                @endphp
                                 <img src="{{ asset('uploads/profile') }}/{{ $userImage }}">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="profle_line">
                        <p class="name_brdr">Jessica Baker</p>
                        <p>45% Completed</p>
                    </div>
                    </div>
            </div>
            <div class="col-md-5 dark_orng_bd">
                <div class="initial_task text-ar-right">
                    <h3>Initial Tasks To be Completed</h3>
                <ul class="complete_task">
                    <li>
                        <div class="pie">20%</div>
                        <a href="#">Know More About EduPlayCloud</a>
                    </li>
                    <li>
                        <div class="pie">80%</div>
                        <a href="#">Add A Class</a>
                    </li>
                    <li>
                        <div class="pie">10%</div>
                        <a href="#">Add Your Own Exercise Set</a>
                    </li>
                    <li>
                        <div class="pie">20%</div>
                        <a href="profile.html" class="active">Complete Profile</a>
                    </li>
                    <li>
                        <div class="pie">210%</div>
                        <a href="#">Share or Publish To Public Exercise Set</a>
                    </li>
                    <li>
                        <div class="pie">80%</div>
                        <a href="#">Invite Learners to your Class</a>
                    </li>
                    <li>
                        <div class="pie">10%</div>
                        <a href="#">Invite Friends to use EduPlayCloud</a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <div class="dashboard_page text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-xl-12">
            <div class="tabs_of_dashbrd">
                <ul>
                    <li><a href="{{ route('exercisesets.exerciseset.private') }}">My Private Library</a></li>
                    <li><a href="my_classes.html">My Classes</a></li>
                    <li><a href="my_tasks.html">My Tasks</a></li>
                    <li><a href="my_assignment_dashbord.html">My Assignments</a></li>
                    <li><a href="reports.html">My Reports</a></li>
                </ul>
            </div>
                <div class="main_dashboard mrgn-tp-30">
                    <h4 class="exersc_title">Recent Activities </h4>
                    <div class="list_of_exercise mrgn-tp-30">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info">
                                    <div  class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/exers_prfl.png') }}" class="img-fluid">
                                        <div class="left_time_info">
                                            <ul class="time_info float-left">
                                                <li>$20</li>
                                                <li class="time_icn">00:10:24</li>
                                            </ul>
                                            <ul class="skill_info float-right">
                                                <li>Skills : 5</li>
                                                <li>Questions : 5</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="title_cmbo">
                                        <li><a href="#">SAT Practice Test #2</a></li>
                                        <li><p>Earth & Life Science</p></li>
                                    </ul>
                                    <ul class="star_wth_user">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="resume_sectn mrgn-tp-30">
                                        <a href="summry_my_private_exercise.html" class="creat_new">Resume</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info pstn_rltv">
                                    <div  class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png')}}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                <img src="{{ asset('assets/eduplaycloud/image/pravte_profl.png')}}">
                                                <p>Rayan Junes</p>
                                            </div>
                                        </div>
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">4</li>
                                                <li class="list_i">10</li>
                                                <li class="user_i_i">112</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="#">Maths Algebra Class</a></li>
                                        <li><p>Maths US</p></li>
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="resume_sectn mrgn-tp-30">
                                        <a href="summry_my_private_exercise.html" class="creat_new">Resume</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="dispine_bg_bx">
                                    <div  class="displin_info">
                                        <img src="image/displn_whit.png" alt="">
                                    </div>
                                    <div class="subject_descripn">
                                    <h5>Physics</h5>
                                    <ul class="bl_or_txt">
                                        <li>Curriculum : 2</li>
                                        <li class="orng_li">Exercise Set : 5</li>
                                    </ul>
                                        <div class="resume_sectn mrgn-tp-30">
                                            <a href="summry_my_private_exercise.html" class="creat_new">Resume</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="dispine_bg_bx">
                                    <div  class="displin_info">
                                        <img src="{{ asset('assets/eduplaycloud/image/displn_whit.png')}}" alt="">
                                    </div>
                                    <div class="subject_descripn">
                                        <h5>Physics</h5>
                                        <ul class="bl_or_txt">
                                            <li>Curriculum : 2</li>
                                            <li class="orng_li">Exercise Set : 5</li>
                                        </ul>
                                        <div class="resume_sectn mrgn-tp-30">
                                            <a href="summry_my_private_exercise.html" class="creat_new">Resume</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main_dashboard mrgn-tp-30">
                    <h4 class="exersc_title">Popular Disciplines For You To Practice</h4>
                    <a href="explore_curiiculum.html" class="see_all_cls">See All</a>
                    <div class="row dscpln_list">
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="javascript:void(0);" class="dcpln_a" data-toggle="modal" data-target="#Maths_Modal" data-dismiss="modal">
                                <img src="{{ asset('assets/eduplaycloud/image/pctc_1.png')}}" alt="">
                                <h5>Maths</h5>
                                <ul class="bl_or_txt">
                                    <li>Curriculum : 2</li>
                                    <li class="orng_li">Exercise Set : 5</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push"></button>
                            <button class="strs_btn hvr-push"></button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="#" class="dcpln_a">
                                <img src="{{asset('assets/eduplaycloud/image/pctc_2.png')}}" alt="">
                                <h5>Science</h5>
                                <ul class="bl_or_txt">
                                    <li>Curriculum : 12</li>
                                    <li class="orng_li">Exercise Set : 25</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push"></button>
                            <button class="strs_btn hvr-push"></button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="#" class="dcpln_a">
                                <img src="{{ asset('assets/eduplaycloud/image/pctc_3.png')}}" alt="">
                                <h5>Physics</h5>
                                <ul class="bl_or_txt">
                                    <li>Curriculum : 22</li>
                                    <li class="orng_li">Exercise Set : 15</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push"></button>
                            <button class="strs_btn hvr-push"></button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="#" class="dcpln_a">
                                <img src="{{ asset('assets/eduplaycloud/image/pctc_4.png')}}" alt="">
                                <h5>Arabic</h5>
                                <ul class="bl_or_txt">
                                    <li>Curriculum : 2</li>
                                    <li class="orng_li">Exercise Set : 5</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push"></button>
                            <button class="strs_btn hvr-push"></button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="#" class="dcpln_a">
                                <img src="{{ asset('assets/eduplaycloud/image/pctc_4.png')}}" alt="">
                                <h5>Arabic</h5>
                                <ul class="bl_or_txt">
                                    <li>Curriculum : 2</li>
                                    <li class="orng_li">Exercise Set : 5</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push"></button>
                            <button class="strs_btn hvr-push"></button>
                        </div>
                    </div>
                </div>
                </div>
                <div class="main_dashboard mrgn-tp-30">
                    <h4 class="exersc_title">Recommended Classes To You</h4>
                    <a href="explore_curiiculum.html" class="see_all_cls">See All</a>
                    <div class="list_of_exercise mrgn-tp-30">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info pstn_rltv">
                                    <div  class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png')}}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                <img src="{{ asset('assets/eduplaycloud/image/pravte_profl.png')}}">
                                                <p>Rayan Junes</p>
                                            </div>
                                        </div>
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">4</li>
                                                <li class="list_i">10</li>
                                                <li class="user_i_i">112</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="request_add add_clrbl abslt_set_add">
                                        <button type="button" class="collbr_btn icon_clrbl">Enroll</button>
                                    </div>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="#">Maths Algebra Class</a></li>
                                        <li><p>Maths US</p></li>
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                                    </div>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info pstn_rltv">
                                    <div class="info_exercise">
                                        <div class="overlay_img"></div>
                                        <img src="{{ asset('assets/eduplaycloud/image/img_dm.png')}}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                <img src="{{ asset('assets/eduplaycloud/image/pravte_profl.png')}}">
                                                <p>Rayan Junes</p>
                                            </div>
                                        </div>
    
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">4</li>
                                                <li class="list_i">10</li>
                                                <li class="user_i_i">112</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button class="btn rqst_btn">Requested</button>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="#">Maths Algebra Class</a></li>
                                        <li><p>Maths US</p></li>
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info pstn_rltv">
                                    <div class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png')}}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                <img src="{{ asset('assets/eduplaycloud/image/pravte_profl.png')}}">
                                                <p>Rayan Junes</p>
                                            </div>
                                        </div>
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">4</li>
                                                <li class="list_i">10</li>
                                                <li class="user_i_i">112</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="request_add add_clrbl abslt_set_add">
                                        <button type="button" class="collbr_btn icon_clrbl">Enroll</button>
                                    </div>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="#">Maths Algebra Class</a></li>
                                        <li><p>Maths US</p></li>
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                                    </div>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                <div class="main_info pstn_rltv">
                                    <div class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png')}}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                <img src="image/pravte_profl.png">
                                                <p>Rayan Junes</p>
                                            </div>
                                        </div>
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">4</li>
                                                <li class="list_i">10</li>
                                                <li class="user_i_i">112</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="request_add add_clrbl abslt_set_add">
                                        <button type="button" class="collbr_btn icon_approvd">Added</button>
                                    </div>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="#">Maths Algebra Class</a></li>
                                        <li><p>Maths US</p></li>
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: 80%;"></div>
                                            </div>
                                            <span class="rtng">4.0</span>
                                        </li>
                                        <li><span>Grade 2</span></li>
                                    </ul>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                                    </div>
                                    <div class="rew_prfl_sectin">
                                        <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}"></div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>Jeffrey Dean </h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>January 31, 2017</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetuer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/circlos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/profile/details.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

@endpush