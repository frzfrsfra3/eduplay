@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page main_grad_cls mrgn_top_secn mrgn-bt-60 text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="mrgn-tp-30 text-ar-right">
                    @include('disciplines.curriculum_breadcrumb',$discipline)
                    <div class="main_summery_earth grade_summery mrgn-tp-30">
                    <div class="earth_publish mrgn-bt-20">
                            <div class="name_list float-left">
                                <h4>{{ $discipline->discipline_name }}</h4>
                            </div>
                            <div class="publist_list vew_skl_rspns float-right">
                                <a href="{{ route('explore.discipline.draft',$discipline->id) }}" class="publish_class_btn">@lang('disciplines.view_grade_wise')</a>
                            </div>
                    </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-sm-7">
                                <h4 class="title_grade_smbld">@lang('disciplines.skill_category')</h4>
                                <a href="create_new_skill_category.html" class="add_orng_btn less_pdn_btn">@lang('disciplines.create_new')</a>
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
                                                        <h3>Grade</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Status</h3>
                                                    </div>
                                                    <div class="class-detail">
                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="section_cls">
                                                        <h3>Collabrator</h3>
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
                        <div class="row">
                            <div class="col-lg-5 col-xl-4">
                                <div class="left_skill_categry">
                                   <ul class="list_clps_inner">
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                               <h4>Geographical Locations - <span>SC0001</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0002</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0003</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0004</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0005</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0006</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="orng_virsn_list">Unpublished</li>
                                                       <li class="orng_virsn_list">Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                       <li class="inner_list_skill">
                                           <div class="title_edit_skill">
                                               <div class="float-left float_ar_right">
                                                   <h4>Geographical Locations - <span>SC0007</span></h4>
                                               </div>
                                               <div class="float-right float_ar_left">
                                                   <div class="edit_cmbo_delt">
                                                       <a href="#" class="edit_icon"></a>
                                                       <a href="#" class="delete_icn"></a>
                                                   </div>
                                               </div>
                                               <div class="clearfix"></div>
                                               <div class="virsn_list">
                                                   <ul>
                                                       <li class="user_name">Jessica Baker </li>
                                                       <li>v1 </li>
                                                   </ul>
                                               </div>
                                               <div class="virsn_list orng_virsn_list">
                                                   <ul>
                                                       <li>Unpublished</li>
                                                       <li>Pending </li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </li>
                                   </ul>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-8">
                                <div class="right_erth_cls">
                                    <h4 class="intr_ntn_cls">{{ $discipline->discipline_name }} @lang('disciplines.international_curriculum')</h4>
                                    <div class="geographical_list">
                                        <div class="accordion accordian_geogp_list" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Geographical Locations - <span>SC0001</span>
                                                        </button>
                                                        <div class="float-right float_ar_left">
                                                            <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></span>
                                                        </div>
                                                        <div class="float-sm-right">
                                                           <h3 class="skill_conter"><span>2</span>@lang('disciplines.skills')</h3>
                                                        </div>
                                                </div>
    
                                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">@lang('disciplines.add_new_skill')</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Geographical Locations - <span>SC0002</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>0</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Geographical Locations - <span>SC0003</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>0</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="card">
                                                <div class="card-header" id="headingFour">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        Geographical Locations - <span>SC0004</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>0</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="card">
                                                <div class="card-header" id="headingFive">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                        Geographical Locations - <span>SC0005</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>11</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingSix">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        Geographical Locations - <span>SC0006</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>10</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingSeven">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                                        Geographical Locations - <span>SC0007</span>
                                                    </button>
                                                    <div class="float-right float_ar_left">
                                                        <span class="arrow_cps_btn" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"></span>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <h3 class="skill_conter"><span>6</span>Skills</h3>
                                                    </div>
                                                </div>
    
                                                <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="add_nw_lst">
                                                            <div class="float-lg-none float-xl-left">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                            </div>
                                                            <div class="float-lg-none float-xl-right mrgn_lg_btm">
                                                                <a href="add_new_skill.html" class="add_orng_btn less_pdn_btn">Add New Skill</a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <ul class="grade_editor_list">
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="sub_grade_list">
                                                                <div class="title_edit_skill">
                                                                    <div class="text-right text-ar-left">
                                                                        <div class="edit_cmbo_delt">
                                                                            <a href="#" class="edit_icon"></a>
                                                                            <a href="#" class="delete_icn"></a>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="two_list virsn_list">
                                                                        <li><h4>Lorem ipsum dolor</h4></li>
                                                                        <li class="orng_virsn_list">Unpublished</li>
                                                                    </ul>
                                                                    <div class="discpn_grad">
                                                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhesse minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
                                                                    </div>
                                                                    <div class="virsn_list">
                                                                        <ul>
                                                                            <li class="user_name">Jessica Baker </li>
                                                                            <li>v1 </li>
                                                                            <li class="orng_virsn_list"> Grade 2</li>
                                                                            <li class="orng_virsn_list"> Pending</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
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