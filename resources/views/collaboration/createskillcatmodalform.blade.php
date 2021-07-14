<div class="modal-dialog">
    <!-- Modal content-->

    <div class="modal-content">
        <div class="modal-header ">
            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span></button>
            <h4 id="gridSystemModalLabel" class="modal-title">Create New Skill Category</h4>
        </div>
        <div class="panel-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" accept-charset="UTF-8" id="create_skillcateory_form" name="create_skillcategory_form"   action="{!! route('skillcategories.skillcategory.store') !!}"  class="form-horizontal">
                {{ csrf_field() }}
                <input class="form-control" name="id_from" type="hidden" id="id_from" value="" minlength="1"
                       maxlength="200" required="true">
                @include ('collaboration.form_skillcatcollaboration', [
                                            'skillcategory' => null,
                                          ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input id="btnSave" class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>