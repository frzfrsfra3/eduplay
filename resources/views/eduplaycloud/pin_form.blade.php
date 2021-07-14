<!-- Create Pin-->
<div class="modal fade default_modal wht_bg_mdl" id="create_pin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                        <h3 id="title">@lang('pins.create_pin')</h3>
                        <form class="def_form" id="pin_form" method="POST" action="{{ route('pins.pin.store') }}" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="url" class="form-control" id="pin_url" placeholder="@lang('pins.paste_url')" required/>
                            </div>
                            <div class="form-group">
                                <textarea name="description" is="pin_description" placeholder="@lang('pins.description')" class="form-control" rows="4"></textarea>
                            </div>
                            <input type="hidden" name="class_id" value="" id="pin_class_id"/>
                            <div class="form-group mrgn-bt-30">
                                <div class="upld_file crsr_p">
                                    <input type="file" title="@lang('messages.choose_file')" accept="image/*" name="image" id="pin_image" onchange="loadFile(event)">
                                    <a href="javascript:void(0);" class="uplod_img">@lang('pins.upload_image')</a>
                                </div>
                                <div class="img_bx">
                                    <img id="output"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="create_pin_btn" class="btn btn-primary btn-login drk_bg_btn">@lang('pins.done')</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Pin-->
<div class="modal fade default_modal wht_bg_mdl" id="edit_pin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3 id="title">@lang('pins.edit_pin')</h3>
                            <form class="def_form" id="edit_pin_form" method="POST" action="{{ route('pins.pin.update') }}" enctype='multipart/form-data'>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" name="url" class="form-control" id="pin_edit_url" placeholder="@lang('pins.paste_url')" required/>
                                </div>
                                <div class="form-group">
                                    <textarea name="description" is="pin_edit_description" placeholder="@lang('pins.description')" class="form-control" rows="4"></textarea>
                                </div>
                                <input type="hidden" name="class_id" value="" id="edit_pin_class_id"/>
                                <input type="hidden" value="" name="id" id="pin_id"/>
                                <div class="form-group mrgn-bt-30">
                                    <div class="upld_file crsr_p">
                                        <input type="file" accept="image/*" name="image" id="pin_edit_image" onchange="loadFile2(event)" />
                                        <a href="javascript:void(0);" class="uplod_img">@lang('pins.upload_image')</a>
                                    </div>
                                    <div class="img_bx">
                                        <img id="output2"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-login">@lang('pins.done')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


