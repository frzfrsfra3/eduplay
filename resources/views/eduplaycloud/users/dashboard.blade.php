@extends('authenticated.layouts.default')
@section('content')
@include('eduplaycloud.users.welcome-header')
<div class="dashboard_page text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="tabs_of_dashbrd">
                @include('eduplaycloud.users.dashboard-menu')
            </div>
            <div class="main_dashboard mrgn-tp-30">
                <h4 class="exersc_title">Recent Activities </h4>
                <div class="list_of_exercise mrgn-tp-20">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                            <div class="main_info">
                                <div  class="info_exercise">
                                    <img src="{{ asset('assets/eduplaycloud/image/exers_prfl.png')}}" class="img-fluid">
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
                                    <li><a href="javascript:;">SAT Practice Test #2</a></li>
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
                                    <li><a href="javascript:;">Maths Algebra Class</a></li>
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
                <a href="{{ route('topics.topic.index') }}" class="see_all_cls">See All</a>
                <div class="row dscpln_list">
                    @if(count($topics) > 0)
                    @foreach ($topics as $topic)
                        <div class="col-sm-6 col-lg-3">
                            <div class="discipline_bx">
                                <a href="javascript:;" class="dcpln_a" data-toggle="modal" data-target="#Maths_Modal" data-dismiss="modal">
                                    @if (strlen($topic->iconurl) == 0 || !File::exists(public_path()."/assets/images/".$topic->iconurl))
                                        <img src="//dummyimage.com/300/cfcfcf/000000.png&text=No+Image" class="borderRadius100" alt="{{ $topic->discipline_name }}">
                                    @else
                                        <img src="{{ asset('assets/images/'.$topic->iconurl) }}" alt="{{ $topic->discipline_name }}">
                                    @endif
                                    <h5>{{ $topic->topic_name }}</h5>
                                    <ul class="bl_or_txt">
                                        <li>@lang('explore.curriculum') : {{ $topic->discipilnes->count() }}</li>
                                        <li class="orng_li">@lang('explore.exercises_set'): {{ $topic->exercisesets->count() }}</li>
                                    </ul>
                                </a>
                                {{--  <button class="stngs_btn hvr-push"></button>
                                <button class="strs_btn hvr-push"></button>  --}}
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="col-sm-6 col-lg-3">
                            <p>No Popular Disciplines Available !!</p>
                        </div>
                    @endif

                    <!-- Maths Modal-->
                    <div class="modal fade default_modal maths_modal" id="Maths_Modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="right_contnt text-ar-right">
                                                <div class="row">
                                                    @include('eduplaycloud.users.discipline-settings')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--  <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="javascript:;" class="dcpln_a" data-toggle="modal" data-target="#Maths_Modal" data-dismiss="modal">
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
                    </div>  --}}
                {{--  <div class="col-sm-6 col-lg-3">
                    <div class="discipline_bx">
                        <a href="javascript:;" class="dcpln_a">
                            <img src="{{ asset('assets/eduplaycloud/image/pctc_2.png')}}" alt="">
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
                        <a href="javascript:;" class="dcpln_a">
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
                        <a href="javascript:;" class="dcpln_a">
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
                        <a href="javascript:;" class="dcpln_a">
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
                </div>  --}}
            </div>
            </div>
            <div class="main_dashboard mrgn-tp-30">
                <h4 class="exersc_title">Recommended Classes To You</h4>
                <a href="javascript:;" class="see_all_cls">See All</a>
                <div class="list_of_exercise mrgn-tp-20">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                            <div class="main_info pstn_rltv">
                                <div  class="info_exercise">
                                    <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png') }}" class="img-fluid">
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
                                    <li><a href="javascript:;">Maths Algebra Class</a></li>
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
                                    <li><a href="javascript:;">Maths Algebra Class</a></li>
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
                                    <li><a href="javascript:;">Maths Algebra Class</a></li>
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
                                    <button type="button" class="collbr_btn icon_approvd">Added</button>
                                </div>
                                <ul class="title_cmbo text-ar-right">
                                    <li><a href="javascript:;">Maths Algebra Class</a></li>
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
                                    <div class="prfl_img"><img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}   "></div>
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
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/circlos.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/profile/details.js') }}"></script>

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>

    /* dynamic grades - Client code  */
    $('#language_id').on('change', function(){
        var topic_id = $(this).data('topic');
        var url=site_url+'/exercisesets/getdisciplies/'+$(this).val()+'/'+topic_id;
        $.get(url,
        function(data) {
            var discipline = $('#discipline_id');
            $('#discipline_id').empty();
            $('#discipline_id').append("<option value=''>" + "Select discipline's Curriculum" + "</option>");
            $.each(data, function(index, discipline) {
                $('#discipline_id').append("<option value='"+ discipline.id +"'>" + discipline.discipline_name + "</option>");
            });
            $('.selectpicker').selectpicker('refresh');
        });
    });


    /* dynamic grades - Client code  */
    $('#discipline_id').on('change', function(){
        var language_id = $("#frmSettings #language_id option:selected").val();
        var url=site_url+'/exercisesets/getgrades/'+$(this).val()+'/'+language_id;
        $.get(url,
        function(data) {
            var grades = $('#grade_id');
            $('#grade_id').empty();
            $('#grade_id').append("<option value=''>" + "Select grade" + "</option>");
            $.each(data, function(index, element) {
                // console.log(element.id);
                $('#grade_id').append("<option value='"+ element.id +"'>" + element.grade_name + "</option>");
            });

            $('.selectpicker').selectpicker('refresh');
        });
    });


    $(document).on('click','#submit-button', function(){
        var form = $('#frmSettings').serialize();
        console.log(form);
        submitDisplineSettingForm(form);
    });


    function submitDisplineSettingForm(form){
        $.ajax({
                type: "get",
                url: "<?php echo route('userinterests.userinterest.updateinterests'); ?>",
                data: form,
                beforeSend: function () {
                    $('.main_loader').show();
                },
                success: function (response) {
                    console.log(response);
                     $('.main_loader').hide(); 
                    if (response.status !== false) {
                        window.location.href = "<?php echo route('topics.topic.exercisesets'); ?>";
                    }
                },
                error: function (err) {
                     $('.main_loader').hide(); 
                    swal('No response from the server.', {
                        closeOnClickOutside: false,
                        icon: 'info',
                    }).then(function() {
                        // location.reload();
                    });
                }
            });
    }

</script>

@endpush