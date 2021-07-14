<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header ">
            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span></button>
            <h4 id="gridSystemModalLabel" class="modal-title">Edit Skill</h4>
        </div>
        <div class="panel-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="GET" accept-charset="UTF-8" id="edit_skill_form" name="edit_skill_form"  action="{!! route('skills.skill.store1') !!}"  class="form-horizontal">
                {{ csrf_field() }}
                <input class="form-control" name="id_from" type="hidden" id="id_from" value="" minlength="1"
                       maxlength="250" required="true">
                <input class="form-control" name="origin_id" type="hidden" id="origin_id" value=""
                       minlength="1" maxlength="250" required="true">
                <div id="htmlid"></div>
                <div id="htmlresponce"></div>

                <div class="form-group">

                    <div class="col-md-offset-2 col-md-10">
                        <input id="btnSave" class="btn btn-primary" type="submit" value="Edit">


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>