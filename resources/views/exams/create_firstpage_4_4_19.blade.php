@extends('authenticated.layouts.default')
<?php /*Load jquery to footer section*/ ?>
@push('inc_css')
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/css/jquery-steps.css') }}" type="text/css" media="all">
@endpush
@section('content')
// assets/eduplaycloud/customs/css/jquery-steps.css
    <!---Content-->
    <div class="work_page mrgn_top_secn exercesi_block mrgn-bt-70 text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('exams.exam.index') }}">My Exams</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Exam</li>
                    </ol>
                    </nav>
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="main_summery_earth mrgn-tp-30">
                            <div class="name_list">
                                <h4>Create Exam</h4>
                            </div>
                            <div id="flashMsg"></div>
                            <div id="demo">
                                <div class="step-app">
                                <ul class="step-steps" style="display:none;">
                                    <li><a href="#tab1"><span class="number">1</span> Step 1</a></li>
                                    <li><a href="#tab2"><span class="number">2</span> Step 2</a></li>
                                    <li><a href="#tab3"><span class="number">3</span> Step 3</a></li>
                                    <li><a href="#tab4"><span class="number">4</span> Step 4</a></li>
                                    <li><a href="#tab5"><span class="number">5</span> Step 5</a></li>
                                </ul>
                                <div class="step-content">
                                    {{-- Tab 1 --}}
                                    <div class="step-tab-panel" id="tab1">
                                        <form id="discipline_frm">
                                            <div class="col-md-5 co-lg-3">
                                            <div class="exam_task">
                                                <div class="form-group big_fnt_plchldr">
                                                    <label>Total Duration : 00:00:00</label>
                                                    <input type="text" name="time" id="time" class="form-control required" placeholder="Total Duration  :  00:00:00" />
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <h5 class="gray-pannel">Step 1: Select Discipline</h5>
                                            <div class="row">
                                                <div class="col-11-rduce col-xl-7">
                                                    <ul class="desipline_list teacher-action">
                                                        <li>
                                                        <div class="form-group mrgn-bt-30">
                                                            <div class="custom-control custom-checkbox">
                                                                <input  value="1" id="selectallDiscipline" type="checkbox" class="custom-control-input">
                                                                <label class="custom-control-label" for="selectallDiscipline">Select All</label>
                                                            </div>
                                                        </div>
                                                        </li>
                                                        @foreach($disciplines as $discipline)
                                                        <li>
                                                        <div class="form-group mrgn-bt-30">
                                                            <div class="custom-control custom-checkbox">
                                                                <input name="selectedId"  value="{{$discipline->id}}" id="discipline_{{$discipline->id}}" type="checkbox" class="custom-control-input selectedDiscipline">
                                                                <label class="custom-control-label" for="discipline_{{$discipline->id}}">{{$discipline->discipline_name}}</label>
                                                            </div>
                                                        </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- Tab 2 --}}
                                    <div class="step-tab-panel" id="tab2">
                                        <h5 class="gray-pannel">Step 2: Select Exercises</h5>
                                        <form name="frmExercisesset" id="frmExercisesset">
                                            <div class="list_of_exercise mrgn-tp-30">

                                            </div>
                                        </form>
                                    </div>
                                    {{-- Tab 3 --}}
                                    <div class="step-tab-panel" id="tab3">
                                        <h5 class="gray-pannel">Step 3: Select Skill Categories</h5>
                                        <form class="categories_form">
                                            <div class="row">
                                                <form name="frmskillCatList" id="frmskillCatList">
                                                    <div class="col-11-rduce col-md-6 col-lg-6 col-xl-3 mrgn-bt-20" id="skillCatList">

                                                    </div>
                                                </form>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="step-tab-panel" id="tab4">
                                        <h3>Tab4</h3>
                                        <form name="frmLogin" id="frmLogin">
                                            Email address:<br>
                                            <input type="text" name="txtEmail" required>
                                            <br> Password:<br>
                                            <input type="text" name="txtPassword" required>
                                        </form>
                                        <h5 class="gray-pannel">Step 4: Select Questions</h5>
                                        <div class="row">
                                            <div class="col-xl-10">
                                            <div class="exam_questions_list mrgn-bt-40">
                                                <div class="form-group">
                                                    <div class="checkbox-sml custom-control custom-checkbox">
                                                        <input  value="1" id="selectall" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="selectall">Select All</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="exam_questions_list pdng_quesn mrgn-bt-40">
                                                <div class="checkbx_abslt">
                                                    <div class="checkbox-sml custom-control custom-checkbox">
                                                        <input name="selectedId"  value="1" id="que1" type="checkbox" class="custom-control-input selectedId">
                                                        <label class="custom-control-label" for="que1"></label>
                                                    </div>
                                                </div>
                                                <div class="que_ans_test">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eu ante a purus tempor semper. Integer pulvinar, libero non condimentum malesuada,</p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-tab-panel" id="tab5">
                                        <h3>Tab5</h3>
                                        <form name="frmMobile" id="frmMobile">
                                            Mobile No:<br>
                                            <input type="text" name="txtMobileNum" required>
                                        </form>
                                        <div class="name_list mrgn-bt-30">
                                            <h4>Exam Details</h4>
                                        </div>
                                        <form class="def_form full_def_frm">
                                            <div class="row">
                                            <div class="col-8-reduce col-xl-8">
                                                <div class="row">
                                                    <div class="col-md-4 col-xl-5">
                                                        <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker">
                                                                <option>Exam Type</option>
                                                                <option>Type</option>
                                                                <option>Type</option>
                                                            </select>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xl-5">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xl-2">
                                                        <div class="form-group mrgn-bt-30">
                                                        <div class="custum-checkbox-tp custom-control custom-checkbox">
                                                            <input name="techer_tpe" value="1" id="Learner" type="checkbox" class="custom-control-input">
                                                            <label class="custom-control-label" for="Learner">Is Available</label>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6-reduce col-xl-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="total_ans_lt">
                                                        <h4>Total Question : <span>4</span></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="total_ans_lt">
                                                        <h4>Total Duration : <span>00:00:00</span></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="total_ans_lt">
                                                        <h4>Total Marks  : <span>00</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-xl-12">
                                                <div class="mark_with_ans">
                                                    <div class="exam_questions_list circl_list pdng_quesn">
                                                        <div class="row">
                                                        <div class="col-md-8 col-xl-10">
                                                            <div class="que_ans_test symbol_black">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eu ante a purus tempor semper. Integer pulvinar, libero non condimentum malesuada,</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xl-2 text-right-def">
                                                            <div class="max-questn">
                                                                <label class="questn_lbl">Marks :</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="step-footer">
                                    <button data-direction="prev" class="btn btn-primary  cancel-btn">Back</button>
                                    <button data-direction="next" class="btn btn-primary add_btn">Next</button>
                                    <button data-direction="finish" class="btn btn-primary add_btn">Save</button>
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
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
    <script src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-steps.js') }}"></script>
    <script>
    $('#startDate1').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $(document).ready(function () {
        // Select all discipline
        $('#selectallDiscipline').click(function () {
            $('.selectedDiscipline').prop('checked', this.checked);
        });

        $('.selectedDiscipline').change(function () {
            var check = ($('.selectedDiscipline').filter(":checked").length == $('.selectedDiscipline').length);
            $('#selectallDiscipline').prop("checked", check);
        });
        // Select all discipline end

        // Select all skillCategories
        $('#selectallskillCat').click(function () {
            $('.selectedskillCat').prop('checked', this.checked);
        });

        $('.selectedskillCat').change(function () {
            var check = ($('.selectedskillCat').filter(":checked").length == $('.selectedskillCat').length);
            $('#selectallskillCat').prop("checked", check);
        });
        // Select all skillCategories end

        $('#selectall').click(function () {
            $('.selectedId').prop('checked', this.checked);
        });

        $('.selectedId').change(function () {
            var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
            $('#selectall').prop("checked", check);
        });
    });
    </script>
    <script>
        // Discipline validation
        var discipline_frm = $('#discipline_frm');
        var discipline_frmValidator = discipline_frm.validate({
            rules: {
                selectedId: {
                    required: true,
                },
            },
            messages: {
                selectedId:  "Please select at least one discipline",
            },
            errorPlacement: function(error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertBefore($(element).parents('.desipline_list'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Exercises set validation
        var frmExercisesset = $('#frmExercisesset');
        var frmExercisessetValidator = frmExercisesset.validate({
            rules: {
                exercisesId: {
                    required: true,
                },
            },
            messages: {
                exercisesId:  "Please select at least one exercises set",
            },
            errorPlacement: function(error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertBefore($(element).parents('.list_of_exercise'));
                }
            }
        });

        // SkillCatList set validation
        var frmskillCatList = $('#frmskillCatList');
        var frmskillCatListValidator = frmskillCatList.validate({
            rules: {
                exercisesId: {
                    required: true,
                },
            },
            messages: {
                exercisesId:  "Please select at least one exercises set",
            },
            errorPlacement: function(error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertBefore($(element).parents('.list_of_exercise'));
                }
            }
        });

        var frmLogin = $('#frmLogin');
        var frmLoginValidator = frmLogin.validate();

        var frmMobile = $('#frmMobile');
        var frmMobileValidator = frmMobile.validate();

        $('#demo').steps({
            onChange: function (currentIndex, newIndex, stepDirection) {
                console.log('onChange', currentIndex, newIndex, stepDirection);

                // tab1
                if (currentIndex === 0) {
                    if (stepDirection === 'forward') {
                        var validDiscipline = discipline_frm.valid();

                        var checkboxValues = [];
                        if(validDiscipline === true){
                            $('input[name="selectedId"]:checked').each(function(index, elem) {
                                checkboxValues.push($(elem).val());
                            });
                                console.log('newindex = '+newIndex);
                                console.log('stepDirection = '+stepDirection);

                                if(newIndex === 1 && stepDirection !== 'backward') {
                                    getExerciseSets(checkboxValues);
                                }
                           }
                            return validDiscipline;

                    }
                    if (stepDirection === 'backward') {
                        console.log('1'+currentIndex);
                    }
                }

                // tab2
                if (currentIndex === 1) {
                    if (stepDirection === 'forward') {
                        var chkExeAvl = $('#noexercisesset').val();
                        if(chkExeAvl != 0){
                            var validExercisesset = frmExercisesset.valid();
                            var execheckboxValues = [];
                            if(validExercisesset === true){
                                $('input[name="exercisesId"]:checked').each(function(index, elem) {
                                    execheckboxValues.push($(elem).val());
                                });
                                $.ajax({
                                    method: "post",
                                    url: '{{route ('Exams.exam.getSkillCategories')}}',
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    data: {
                                        id: execheckboxValues,
                                    },
                                    success: function (response) {
                                        $('#skillCatList').html(response);
                                    }
                                });
                                return validExercisesset;
                            }
                        } else {
                            $('#flashMsg').html('');
                            $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Danger!</strong> Selected discipline not have any exercises set.</div>');
                            return false;
                        }
                    }
                    if (stepDirection === 'backward') {
                        console.log(currentIndex);
                    }
                }

                // tab3
                if (currentIndex === 2) {
                    /*if (stepDirection === 'forward') {
                        var valid = frmLogin.valid();
                        return valid;
                    }*/
                    if (stepDirection === 'backward') {
                        console.log('demi');
                    }
                }

                // tab3
                if (currentIndex === 4) {
                    if (stepDirection === 'forward') {
                    var valid = frmMobile.valid();
                    return valid;
                    }
                    if (stepDirection === 'backward') {
                        console.log(currentIndex);
                    }
                }

                return true;

            },
            onFinish: function () {
            alert('Wizard Completed');
            }
        });



        function getExerciseSets(checkboxValues){
            $.ajax({
                method: "post",
                url: '{{route ('Exams.exam.getExercisesset')}}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    id: checkboxValues,
                },
                success: function (response) {
                    $('.list_of_exercise').html(response);
                }
            });
        }
    </script>
@endpush