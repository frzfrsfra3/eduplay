@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="mrgn-tp-30 text-ar-right">
                    @include('disciplines.curriculum_breadcrumb',$discipline)
                    <div class="row">
                        <div class="col-md-10">
                                <div class="tbs_of_report tbs_of_report-as">
                                        <ul class="tabs_menu tabs_curiiculumn nav">
                                        <li class="nav-item"><a class="nav-link " href="{{ route('explore.discipline.summary',$discipline->id) }}">@lang('disciplines.summary')</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('explore.discipline.published',$discipline->id)}}">@lang('disciplines.latest_published_version')</a></li>
                                            <li class="nav-item"><a class="nav-link active" href="{{ route('explore.discipline.draft',$discipline->id) }}">@lang('disciplines.latest_draft')</a></li>
                                        </ul>
                                </div>
                        </div>
                        <div class="col-md-2 mrgn-tp-30 rspnsv_cls">
                            <div class="form-group serch_section text-right">
                                <span class="form-control-serch"></span>
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="main_summery_earth grade_summery">
                    <div class="earth_publish mrgn-bt-10">
                            <div class="name_list float-left">
                                <h4>{{ $discipline->discipline_name }}</h4>
                            </div>
                            <div class="publist_list vew_skl_rspns float-right">
                                <a href="{{ route('explore.discipline.draft.skill',$discipline->id ) }}" class="publish_class_btn">@lang('disciplines.view_skill_wise')</a>
                            </div>
                    </div>
                        <div class="clearfix"></div>
                        <h6 class="title_grade_smbld">@lang('disciplines.grades_curriculum')</h6>
                        <div class="row">
                            <div class="col-sm-7">
                                <h4 class="grade_medm_fnt">@lang('disciplines.grades')</h4>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_model" data-dismiss="modal" class="add_orng_btn">Add</a>
                            </div>
                            <div class="col-sm-5 text-right">
                                <div class="short_by">
                                    <div class="short_by_select nw_algn">
                                        <label>Sort By:</label>
                                        <select class="selectpicker">
                                            <option>Newest</option>
                                            <option>Newest1</option>
                                            <option>Newest2</option>
                                        </select>
                                    </div>
                                    <div class="filter">
                                        <div class="cstm-drpdwn">
                                            <span class="flr-i">Filters</span>
                                        </div>
                                        <div class="slct_drop_box">
                                            <ul class="demo-accordion accordionjs " data-active-index="false">
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Name</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Description </h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Discipline </h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Language Pack</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-primary apply_sm_btn">Apply</button>
                                        </div>
                                    </div>
                                    <div class="clear_all_cls">
                                        <a href="#" class="clear_all_btn">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bd-example bd-example-tabs mrgn-tp-20">
                            <div class="row">
                                <div class="col-md-4 col-xl-3 pdn_rigt_less">
                                    <div class="grade_tabs nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false">Kindergarten
                                            <span class="counter_vlue">2</span>
                                        </a>
                                        <ul class="grade_list">
                                            <li>Anatomy & Morphology</li>
                                            <li>Geographical Locations</li>
                                            <li>Ecology & Evolution</li>
                                            <li>Forestry</li>
                                        </ul>
                                        <a class="nav-link active show" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Grade 1
                                            <span class="counter_vlue">2</span>
                                        </a>
                                        <ul class="grade_list">
                                            <li>Anatomy & Morphology <span class="counter_vlue">1</span></li>
                                            <li>Geographical Locations <span class="counter_vlue">2</span></li>
                                            <li>Ecology & Evolution <span class="counter_vlue">3</span></li>
                                            <li>Forestry</li>
                                        </ul>
                                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Grade 2</a>
                                        <ul class="grade_list">
                                            <li>Anatomy & Morphology</li>
                                            <li>Geographical Locations</li>
                                            <li>Ecology & Evolution</li>
                                            <li>Forestry</li>
                                        </ul>
                                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true">Grade 3</a>
                                        <ul class="grade_list">
                                            <li>Anatomy & Morphology</li>
                                            <li>Geographical Locations</li>
                                            <li>Ecology & Evolution</li>
                                            <li>Forestry</li>
                                        </ul>
                                        <a class="nav-link" id="v-pills-grade4-tab" data-toggle="pill" href="#v-pills-grade4" role="tab" aria-controls="v-pills-grade4" aria-selected="true">Grade 4</a>
                                        <a class="nav-link" id="v-pills-grade5-tab" data-toggle="pill" href="#v-pills-grade5" role="tab" aria-controls="v-pills-grade5" aria-selected="true">Grade 5</a>
                                        <a class="nav-link" id="v-pills-grade6-tab" data-toggle="pill" href="#v-pills-grade6" role="tab" aria-controls="v-pills-grade6" aria-selected="true">Grade 6</a>
                                        <a class="nav-link" id="v-pills-grade7-tab" data-toggle="pill" href="#v-pills-grade7" role="tab" aria-controls="v-pills-grade7" aria-selected="true">Grade 7</a>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xl-9 pdn_left_less">
                                    <div class="tab-content inner_grade_panel" id="v-pills-tabContent">
                                        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="detail_of_grade">
                                                <h2>Kindergarten</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 1</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
    
                                                <div class="accordion grade_acordian mrgn-tp-40" id="main_accordian">
                                                    <div class="card">
                                                        <div class="card-header btn_pdn_ls" id="headingOne">
                                                            <button class="btn_blue_round" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link btn_blk_colps" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Anatomy & Morphology</button>
                                                            <div class="edit_cmbo_delt">
                                                                <a href="#" class="edit_icon"></a>
                                                                <a href="#" class="delete_icn"></a>
                                                            </div>
                                                        </div>
                                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#main_accordian">
                                                            <div class="card-body">
                                                                <div class="accordion inner_acco_tp" id="subcategories_accordion">
                                                                    <div class="card">
                                                                        <div class="card-sub_header btn_clps_nw active-as" id="subheading_one">
                                                                            <button class="btn btn-link sub_list_btn" type="button" data-toggle="collapse" data-target="#collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1">Lorem ipsum dolor sit amet</button>
                                                                            <div class="edit_cmbo_delt">
                                                                                <a href="#" class="edit_icon"></a>
                                                                                <a href="#" class="delete_icn"></a>
                                                                            </div>
                                                                            <div class="float-right float_ar_left">
                                                                                <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1"></span>
                                                                            </div>
                                                                            <div class="float-sm-right">
                                                                                <ul class="coment_list">
                                                                                    <li><a href="#">Comment</a></li>
                                                                                    <li><a href="#">Approve</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse_sub1" class="collaps_tp collapse show" aria-labelledby="subheading_one" data-parent="#subcategories_accordion">
                                                                            <div class="grade_inner_desccriptn">
                                                                                <p><span>KCC. 1</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                                                                                <p><span>KCC. 2</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-sub_header btn_clps_nw" id="subheading_Two">
                                                                            <button class="btn btn-link sub_list_btn" type="button" data-toggle="collapse" data-target="#collapse_sub2" aria-expanded="true" aria-controls="collapse_sub2">Lorem ipsum dolor sit amet</button>
                                                                            <div class="edit_cmbo_delt">
                                                                                <a href="#" class="edit_icon"></a>
                                                                                <a href="#" class="delete_icn"></a>
                                                                            </div>
                                                                            <div class="float-right float_ar_left">
                                                                                <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapse_sub2" aria-expanded="true" aria-controls="collapse_sub2"></span>
                                                                            </div>
                                                                            <div class="float-sm-right">
                                                                                <ul class="coment_list">
                                                                                    <li><a href="#">Comment</a></li>
                                                                                    <li><a href="#">Approve</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse_sub2" class="collaps_tp collapse" aria-labelledby="subheading_Two" data-parent="#subcategories_accordion">
                                                                            <div class="grade_inner_desccriptn">
                                                                                <p><span>KCC. 1</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="add_collps mrgn-bt-40 mrgn-tp-20">
                                                                    <a href="#" class="clps_btn_add"></a>
                                                                    <div class="divider_gray"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-header btn_pdn_ls" id="headingTwo">
                                                            <button class="btn_blue_round collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link btn_blk_colps" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Geographical Locations</button>
                                                            <div class="edit_cmbo_delt">
                                                                <a href="#" class="edit_icon"></a>
                                                                <a href="#" class="delete_icn"></a>
                                                            </div>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#main_accordian">
                                                            <div class="card-body">
                                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure  dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui  blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi</p>
                                                                <p>Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut   wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                <div class="accordion inner_acco_tp" id="subcategories_accordion_two">
                                                                    <div class="card">
                                                                        <div class="card-sub_header btn_clps_nw active-as" id="subheading_one_1">
                                                                            <button class="btn btn-link sub_list_btn " type="button" data-toggle="collapse" data-target="#collapse_sub3" aria-expanded="true" aria-controls="collapse_sub3">Lorem ipsum dolor sit amet</button>
                                                                            <div class="edit_cmbo_delt">
                                                                                <a href="#" class="edit_icon"></a>
                                                                                <a href="#" class="delete_icn"></a>
                                                                            </div>
                                                                            <div class="float-right float_ar_left">
                                                                                <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapse_sub3" aria-expanded="true" aria-controls="collapse_sub3"></span>
                                                                            </div>
                                                                            <div class="float-sm-right">
                                                                                <ul class="coment_list">
                                                                                    <li><a href="#">Comment</a></li>
                                                                                    <li><a href="#">Approve</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse_sub3" class="collaps_tp collapse show" aria-labelledby="subheading_one_1" data-parent="#subcategories_accordion_two">
                                                                            <div class="grade_inner_desccriptn">
                                                                                <p><span>KCC. 1</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                                                                                <p><span>KCC. 2</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-sub_header btn_clps_nw" id="subheading_Two_2">
                                                                            <button class="btn btn-link sub_list_btn" type="button" data-toggle="collapse" data-target="#collapse_sub4" aria-expanded="true" aria-controls="collapse_sub4">Lorem ipsum dolor sit amet</button>
                                                                            <div class="edit_cmbo_delt">
                                                                                <a href="#" class="edit_icon"></a>
                                                                                <a href="#" class="delete_icn"></a>
                                                                            </div>
                                                                            <div class="float-right float_ar_left">
                                                                                <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapse_sub4" aria-expanded="true" aria-controls="collapse_sub4"></span>
                                                                            </div>
                                                                            <div class="float-sm-right">
                                                                                <ul class="coment_list">
                                                                                    <li><a href="#">Comment</a></li>
                                                                                    <li><a href="#">Approve</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse_sub4" class="collaps_tp collapse" aria-labelledby="subheading_Two_2" data-parent="#subcategories_accordion_two">
                                                                            <div class="grade_inner_desccriptn">
                                                                                <p><span>KCC. 1</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex sectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="add_collps mrgn-bt-40 mrgn-tp-20">
                                                                    <a href="#" class="clps_btn_add"></a>
                                                                    <div class="divider_gray"></div>
                                                                </div>
                                                            </div>
    
                                                        </div>
                                                        <div class="card-header btn_pdn_ls" id="headingThree">
                                                            <button class="btn_blue_round collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link btn_blk_colps" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Ecology & Evolution</button>
                                                            <div class="edit_cmbo_delt">
                                                                <a href="#" class="edit_icon"></a>
                                                                <a href="#" class="delete_icn"></a>
                                                            </div>
                                                        </div>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#main_accordian">
                                                            <div class="card-body">
                                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure  dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui  blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi</p>
                                                                <p>Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut   wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                            </div>
                                                        </div>
                                                        <div class="card-header btn_pdn_ls" id="headingFour">
                                                            <button class="btn_blue_round collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link btn_blk_colps" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">Forestry</button>
                                                            <div class="edit_cmbo_delt">
                                                                <a href="#" class="edit_icon"></a>
                                                                <a href="#" class="delete_icn"></a>
                                                            </div>
                                                        </div>
                                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#main_accordian">
                                                            <div class="card-body">
                                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut  wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure  dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui  blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi</p>
                                                                <p>Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut   wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                            </div>
    
                                                        </div>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 2</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 3</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-grade4" role="tabpanel" aria-labelledby="v-pills-grade4-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 4</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-grade5" role="tabpanel" aria-labelledby="v-pills-grade5-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 5</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-grade6" role="tabpanel" aria-labelledby="v-pills-grade6-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 6</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-grade7" role="tabpanel" aria-labelledby="v-pills-grade7-tab">
                                            <div class="detail_of_grade">
                                                <h2>Grade 7</h2>
                                                <p class="big_fnt">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna  aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
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
        </div>
    </div>
    <!--add_grades-->
    <div class="modal fade default_modal wht_bg_mdl" id="add_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>Add Grade</h3>
                                <form class="def_form">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Grade Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Previous Grade">
                                    </div>
                                    <div class="form-group publis_mrgn">
                                        <button type="button" class="btn btn-primary btn-login">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---End Content-->
@endsection
<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
        $('#startDate1').datetimepicker({
            format: 'DD/MM/YYYY'
        });
</script>
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
@endpush