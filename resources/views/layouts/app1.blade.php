<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        EduPlayCloud.com - @section('title')
        @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,600i,700,700i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{--  <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/fonts.css') }}" media="all" type="text/css">  --}}
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/bootstrap.min.css') }}" media="all" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/style.css') }}" media="all" type="text/css">
    {{--  <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/rtl.css') }}" media="all" type="text/css">  --}}
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/css/bootstrap-datetimepicker.css') }}" type="text/css" media="all">

    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->

</head>
<body id="page-top">
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-4 text-ar-right"><a class="navbar-brand" href="index.html"><img src="{{ asset('assets/eduplaycloud/image/logo.svg') }}" alt="" class="logo"></a></div>
            <div class="col-8 text-right text-ar-left">
                <ul class="header_nave">
                    <li class="mrgn_rtlf">
                        <nav class="navbar navbar-expand-lg" id="mainNav">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse nv_light collps_menu" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active"><a class="nav-link js-scroll-trigger" href="index.html">Home</a></li>
                                    <li class="nav-item"><a class="nav-link p" href="explore_curiiculum.html">Explore</a></li>
                                </ul>
                            </div>
                        </nav>
                    </li>
                    <li class="combo_lgnsp mrgn_rtlf"><a class="lgn_link brdr_rht" href="javascript:void(0)" data-toggle="modal" data-target="#login_btn">Login</a><a class="lgn_link" href="javascript:void(0)" data-toggle="modal" data-target="#sign_up">Sign Up</a></li>
                    <li class="custm_drp dropdown mrgn_rtlf">
                        <a class="drp_link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">English</a>
                        <div id="lang_picker" class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a data-value="en" class="dropdown-item" href="#">English</a>
                            <a data-value="ar" class="dropdown-item" href="#">Arabic</a>
                        </div>
                        <!--<select id="lang_picker">
                            <option value="en">English</option>
                            <option value="ar" >Arabic</option>
                        </select>-->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div id="carouselExampleControls" class="carousel slide stream_slider" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <div class="spn_lin">
                        <span class="next_line">Next</span>
                    </div>

                </div>
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>Streamline Education</h4>
                    <h3>Through Gaming</h3>
                    <p>Play, Learn and Teach your desired Discipline;
                        Monitor your kids progress through our inter active, fun based knowledge development platform.</p>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#get_started" data-dismiss="modal" class="getstrd_btn">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="our_position" id="our_position">
    <div class="container">
        <div class="row">
            <div class="col-md-7 wht_clr">
                <div class="value_postn text-ar-right">
                  <h3>Our <span>Value Proposition</span></h3>
                    <div class="for_teacher">
                       <div class="bg_techer">
                           <h4>For Teachers</h4>
                           <p>Create your own exercise sets, publish them to public library or share with you own students</p>
                       </div>
                        <a href="teachers.html" class="learn_more">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="right_man">
                    <img class="img-fluid" src="{{ asset('assets/eduplaycloud/image/man.jpg') }}">
                    <div class="bottom_arw">
                        <a class="next_btm p" href="#for_student">
                            <span class="icon_btm"></span>
                        </a>
                        <h3>Next</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="for_student" id="for_student">
    <div class="container reltv_cls">
        <div class="row">
            <div class="col-md-7">
                <div class="orng_img">
                    <img src="{{ asset('assets/eduplaycloud/image/4_n.png') }}" class="img-fluid">
                </div>
            </div>
            <div class="col-md-5">
                <div class="for_inner_studnt text-ar-right">
                    <div class="bg_techer">
                        <h4>For Students</h4>
                        <p>Explore various disciplines in a private library, and practice various skills across different domains.</p>
                    </div>
                    <a href="students.html" class="learn_more">Learn More</a>
                </div>
            </div>
            </div>
        <div class="orng_bottom_arw">
            <a class="orng_pre_btm p" href="#our_position"><span class="orng_preicn_btm"></span></a>
            <a class="orng_next_btm p" href="#for_perents"><span class="orng_icon_btm"></span></a>
            <h3>Next</h3>
        </div>
        </div>
</section>
<section class="for_perents" id="for_perents">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-6">
                        <div class="prent_bg text-ar-right">
                            <div class="bg_techer">
                                <h4>For Parents</h4>
                                <p>Organize your children&#39;s gaming and other online activities, invite them to learn a class, create exercise sets, and monitor their progress.</p>
                            </div>
                            <a href="parents.html" class="learn_more">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pernt_img">
                            <img src="{{ asset('assets/eduplaycloud/image/grp.png')}}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="abso_cmbo_btn">
        <a class="cm_pre p" href="#for_student"><span class="cm_icon_pre"></span></a>
        <a class="cm_next p" href="#for_work"><span class="cm_icon_next"></span></a>
        <h3>Next</h3>
    </div>
</section>
<section class="for_work text-ar-right" id="for_work">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row justify-content-center">
                    <div class="col-lg-8 lft_wt">
                        <h2><span>How </span>EduPlayCloud Works</h2>
                        <p>We are focused towards creating an interactive educational platform. Starting from your signing up with EduPlayCloud to exploring/learning different class materials, we're focused towards making things easier for you. Here's a step-by-step guide to how we help you plug-and-play with EduPlayCloud.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 rtg_wt">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <ul class="flow_list">
                            <li>
                                <h4><i class="jn_lgn_i"></i>Join | Login <span class="n_counts">01</span></h4>
                                <p>Create an account with EduPlayCloud using your personal e-mail, Gmail or Facebook account and choose your role.</p>
                            </li>
                            <li>
                                <h4><i class="explr_i"></i>Explore Disciplines <span class="n_counts">02</span></h4>
                                <p>Discover your expertise in diﬁerent disciplines: explore and grow your skills across multiple educational domains.</p>
                            </li>
                            <li>
                                <h4><i class="strt_crtng_i"></i>Start Creating Content <span class="n_counts">03</span></h4>
                                <p>Create personalized learning contents; manage contents of your private library. publish to a world-class audience.</p>
                            </li>
                            <li>
                                <h4><i class="invt_ern_i"></i>Invite & Earn Points <span class="n_counts">04</span></h4>
                                <p>Encourage your friends/learners to join EduPlayCloud and learn/create new exercise sets to gain experience points,</p>
                            </li>
                            <li>
                                <h4><i class="invt_trnrs_i"></i>Grow Your Community <span class="n_counts">05</span></h4>
                                <p>Invite tearners/parents/teachers to play games. create contents and contribute to the global EduPlayCloud community.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="for_need text-ar-right">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-xl-3">
                        <h2><span>Why You</span> Need EduPlayCloud</h2>
                    </div>
                    <div class="col-xl-7 p_need">
                        <p>Stay focused on the skills you need to learn while playing. EduplayCloud is focused toward creating a platform where you can practice knowledge skills in fun and effective way.</p>
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>Mastery Independent Progress</h6>
                        <p>EduplayCloud creates a progressive learning environment that allows the learners to progress through the class even if they haven't mastered the previous levels.</p>
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>Create Long-Lasting Classes</h6>
                        <p>Create your own Exercise Sets. You can build a questions bank with easy to use templates</p>
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>Oversee Kids Online Activity</h6>
                        <p>Parents can stop worrying about your children's online activity. Monitor their online activity, create personalized educational contents, and instantly access their reports.</p>
                    </div>

                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>Choose Your Own Curriculum</h6>
                        <p>EduplayCloud offers extended international learning contents that help every student to attain world class knowledge through easy learning.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="for_did_you_know text-ar-right">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-12">
                        <div class="did_n_content">
                            <h2><span>Did You</span> Know</h2>
                            <p>Education is not the learning of facts, but the training of the mind to think.</p>
                            <a href="#">- Albert Einstein</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="container">
    <div class="top_footer">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <ul class="ph_mail_link">
                        <li><a href="#" class="ph_link">+961 81 864 912</a></li>
                        <li><a href="#" class="mail_link">info@eduplaycloud.com</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <ul class="footer_links_prvcy">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Forum</a></li>
                        <li><a href="#">messages.blog</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <ul class="footer_links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Who We Are</a></li>
                        <li><a href="#">What We do</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <ul class="share_links">
                        <li><a href="#" class="fb_i"></a></li>
                        <li><a href="#" class="twtr_i"></a></li>
                        <li><a href="#" class="lnkn_i"></a></li>
                        <li><a href="#" class="insgm_i"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom_footer">
            <p>Copyright © 2019</p>
        </div>
    </div>
</footer>

<!--login-popup-->
<div class="modal fade default_modal" id="login_btn" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_lgn">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <h4>Good to see you again.</h4>
                            <p>By logging into you agree to our <a href="{{ URL('terms') }}" target="_blank">Terms of use</a> and <a href="{{ URL('privacy') }}" target="_blank">Privacy Policy</a></p>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt logn_info text-ar-right">
                            <h3>Login</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group mrgn_bt mrgn-bt-40">
                                    <input type="password" class="form-control" placeholder="Password">
                                    <div class="text-right">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#frgt_btn" data-dismiss="modal" class="forgt_pswd">Forgot Password</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-login">Login</button>
                                </div>
                            </form>
                            <div class="or_cnected">
                                <p>Or connect with</p>
                                <div class="fbc_gogl_combo">
                                    <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">Connect with Facebook</button>
                                    <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">Connect with Google</button>
                                </div>
                                <div class="dont_have">
                                    <p>Don’t Have An Account? <a href="javascript:void(0)" class="click_me" data-toggle="modal" data-target="#sign_up" data-dismiss="modal">SIgn Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sign_up-->
<div class="modal fade default_modal" id="sign_up" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_sinup">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt">
                            <div class="logn_left text-ar-right">
                            <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt logn_info text-ar-right">
                            <h3>Sign Up</h3>
                            <div class="item_cmo">
                                <h6>Welcome to EduPlayCloud</h6>
                                <p>I&#39;m your assistance. I will help you in going step by step through creating
                                    your account</p>
                            </div>
                            <form class="def_form">
                                <div class="form-group date_btm_mrgn">
                                    <input type="text" class="form-control" placeholder="Date Of Birth" id="startDate">
                                </div>
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#procced_btn" data-dismiss="modal" class="btn btn-primary btn-login">Proceed</button>
                                </div>
                            </form>
                            {{--  <div class="or_less_then none">
                                <p>Or Less Than <a href="javascript:void(0)" data-toggle="modal" data-target="#13_year_child" data-dismiss="modal">13 Years</a></p>
                            </div>  --}}
                            <div class="dont_have">
                                <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--process_popup-->
<div class="modal fade default_modal" id="procced_btn" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_sinup">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt">
                            <div class="logn_left text-ar-right">
                                <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt logn_info text-ar-right">
                            <h3>Select Your Topics</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <ul class="prsn-action">
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="maths" type="checkbox" class="custom-control-input" checked>
                                                <img src="{{ asset('assets/eduplaycloud/image/maths.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">Maths</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="science" type="checkbox" class="custom-control-input">
                                                <img src="{{ asset('assets/eduplaycloud/image/science.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">Science</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="Physics" type="checkbox" class="custom-control-input">
                                                <img src="{{ asset('assets/eduplaycloud/image/physcs.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">Physics</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="Arabic" type="checkbox" class="custom-control-input">
                                                <img src="{{ asset('assets/eduplaycloud/image/arbic.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">Arabic</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="English" type="checkbox" class="custom-control-input">
                                                <img src="{{ asset('assets/eduplaycloud/image/english.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">English</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="maths" value="" id="Sociology" type="checkbox" class="custom-control-input">
                                                <img src="{{ asset('assets/eduplaycloud/image/socioligy.png') }}" class="img_checkbox img-fluid">
                                                <label class="custom-control-label">Sociology</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group mrgnt back_top_mrgn">
                                    <button type="button" data-toggle="modal" data-target="#next-techer" data-dismiss="modal" class="btn btn-primary btn-login">Next</button>
                                    <button type="button" class="bake_btn">Back</button>
                                </div>
                            </form>

                            <div class="dont_have">
                                <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sign_up_next-->

<div class="modal fade default_modal" id="next-techer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="signup_content modal-content img_fr_sinup">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left">
                                <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt sign_up_info logn_info text-ar-right">
                            <h3>Sign Up</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <ul class="teacher-action">
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Learner" type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="Learner">Learner</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Teacher" type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="Teacher">Teacher</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Parent" type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="Parent">Parent</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Full Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group mrgn_less mrgn-bt-40">
                                    <input type="password" class="form-control" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-login">Sign Up</button>
                                </div>
                            </form>
                            <div class="mrgn_less or_cnected">
                                <p>Or connect with</p>
                                <div class="fbc_gogl_combo">
                                    <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">Connect with Facebook</button>
                                    <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">Connect with Google</button>
                                </div>
                                <div class="mrgn_less dont_have">
                                    <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--forgot-passwrd-->
<div class="modal fade default_modal" id="frgt_btn" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_frgtpswd">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left">
                                <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt sign_up_info logn_info text-ar-right">
                            <h3>Forgot Password</h3>
                            <p class="enter_youremil">Enter your email address registered with us to receive the code to reset your password</p>
                            <form class="def_form">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group mrgn_frgt">
                                    <button type="button" class="btn btn-primary btn-login">Send</button>
                                </div>
                            </form>
                            <div class="mrgn_less or_cnected">
                                <div class="mrgn_less dont_have">
                                    <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#reset_pswrd" data-dismiss="modal">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--reset_pswrd-->
<div class="modal fade default_modal" id="reset_pswrd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_frgtpswd">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left">
                                <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt sign_up_info logn_info text-ar-right">
                            <h3>Reset Password</h3>
                            <p class="enter_youremil">Enter the code sent to your registered email address with us, to reset your password</p>
                            <form class="def_form">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirm New Password">
                                </div>
                                <div class="form-group mrgn_reset">
                                    <button type="button" class="btn btn-primary btn-login">Reset</button>
                                </div>
                            </form>
                            <div class="reset_cectd or_cnected">
                                <div class="mrgn_less dont_have">
                                    <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--want_we_processd-->
<div class="modal fade default_modal" id="get_started" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="signup_content modal-content img_fr_lgn">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left">
                                <p>Helping every student succeed with personalized practice</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt getsrtd_info sign_up_info logn_info text-ar-right">
                            <h3>Want To Proceed As</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <ul class="teacher-action">
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Learner1" type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="Learner1">Learner</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Teacher2" type="checkbox" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="Teacher2">Teacher</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input name="techer_tpe" value="1" id="Parent3" type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="Parent3">Parent</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-login">Proceed</button>
                                </div>
                            </form>
                            <div class="mrgn_less or_cnected">
                                <p>Or connect with</p>
                                <div class="fbc_gogl_combo">
                                    <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">Connect with Facebook</button>
                                    <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">Connect with Google</button>
                                </div>
                                <div class="dont_have">
                                    <p>Don’t Have An Account? <a href="javascript:void(0)" class="click_me" data-toggle="modal" data-target="#sign_up" data-dismiss="modal">SIgn Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade default_modal small_deflt_mdl" id="13_year_child" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left child_left">
                                <h6>If my child is younger than 13 years,
                                    what login options are there?</h6>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales nisl mauris, nec tincidunt purus pretium dapibus. Pellentesque ut pretium erat, vitae aliquam enim. Ut ut mollis turpis. Integer nisl erat, imperdiet ac ex non, vehicula maximus lorem. Proin sed tempus ante, non porta nunc. Nulla laoreet non lacus nec tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas vitae tortor dictum, aliquet lacus blandit, imperdiet magna.</p>
                                <p>Praesent ultrices, nisl eget dictum scelerisque, ligula nulla dapibus massa, eget tempus nunc sapien quis lacus. Proin rhoncus ut dui at egestas. Nullam vehicula tellus a turpis malesuada, vitae lobortis urna pretium. Morbi maximus porttitor sodales. Mauris dictum purus nibh, at venenatis tellus laoreet ornare. Donec faucibus metus dui. Morbi vel faucibus lacus, ac semper nisl. Duis justo sem, pretium quis ipsum ut, laoreet varius orci. Fusce eget augue mattis, placerat purus nec, maximus sem. Pellentesque et augue tincidunt, volutpat tortor venenatis, rhoncus lectus. Ut hendrerit et felis ac pharetra.</p>
                                <p class="bold_text">Phasellus et urna imperdiet, luctus nisl vitae, mattis lectus. Aliquam sagittis, ante at tincidunt placerat, libero elit semper ante, et dictum nisi dolor quis dui. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt right_present logn_info text-ar-right">
                            <div class="item_cmo">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales nisl mauris, nec tincidunt purus pretium dapibus. Pellentesque ut pretium erat, vitae aliquam enim. Ut ut mollis turpis. Integer nisl erat, imperdiet ac ex non, vehicula maximus lorem. Proin sed tempus ante, non porta nunc. Nulla laoreet non lacus nec tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas vitae tortor dictum, aliquet lacus blandit, imperdiet magna.</p>
                            </div>
                            <div class="presnt_grp">
                                <p>Please enter your parent’s or guardian’s email address and we will send them instructions for the next step in  your signup.</p>
                            </div>
                            <form class="def_form">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Parent’s Email Address">
                                </div>
                                <div class="form-group mrgn_mr_add">
                                    <button type="button" data-toggle="modal" data-target="#procced_btn" data-dismiss="modal" class="btn btn-primary btn-login">Submit</button>
                                </div>
                            </form>
                            <div class="dont_have">
                                <p>Already Have An Account?<a href="javascript:void(0)" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="{{ asset('assets/eduplaycloud/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/js/custom.js') }}"></script>
<script>
    function facebookclose(url) {
        parent.location = url;
    }

    $('#startDate').datetimepicker({
        format: 'DD/MM/YYYY'
    });
</script>
</body>
</html>