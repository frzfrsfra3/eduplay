<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content col-xs-12 col-sm-12">
        <div class="modal-header ">
            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span></button>
            </div>

            <div class="exerciseset-form" id="exerciseset-form">
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="exerciseset-details" >
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding"  style="">
                         <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box" >
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-title"> {{ $passage->passage_title }}</div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">

                                    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 exercise-description"> {!!  nl2br($passage->passage_text)  !!}</div>
                                </div>
                            </div>



                        </div>
                    </div>
    </div>
</div>

    </div>
</div>