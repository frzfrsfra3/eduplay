@extends('guest.layouts.default')
@section('content')
<style>
.header {
    background-color: #fff;
    box-shadow: 3px 3px 1px 0 rgba(0, 0, 0, 0.2);
    padding: 25px 0 20px 0;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
}

.header .combo_lgnsp .lgn_link, .header .custm_drp a, .header .header_nave .nav-link {
    color: #ff9028;
}
</style>
<section class="practice_exercises bg_white mrgn_top_secn">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                @lang('landing.parent_approval_your_child') <u>{{ $user->name }}</u> @lang('landing.parent_approval_content')
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="javascript:;" class="accept">
                    <button class="btn btn-primary" type="button">@lang('landing.parent_approval_accept')</button>
                </a>
                <a href="javascript:;" class="reject">
                    <button class="btn btn-danger btn-accept border-danger" type="button">@lang('landing.parent_approval_reject')</button>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/functions.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script type="text/javascript">
    $(function () {
        $("input:file").change(function () {
            var fileName = $(this).val();
            var url = $(this).data("url");
            var image = $('#upload-photo')[0].files[0];
            var form = new FormData();
            var formData = new FormData($('#upload_form')[0]);

            $.ajax({
                url: url,
                data: formData,
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                beforeSend:function(){
                    // Show image here
                    $("#ajax-img").show();
                },
                complete:function(){
                    // Hide image here
                    $("#ajax-img").hide();
                },
                success: function (response) {
                    $("#user_img").attr("src", "{{ asset('assets/images') }}/" + response['filename']);
                    $("#ajax-img").hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#ajax-img").hide();
                }
            });
        });
    });

    function addrole(url) {
        $.ajax({
            type: "POST",
            dataType: "text",
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                location.reload();
            },
            error: function (err) {
                // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        })
    }

    function removerole(url) {
        $.ajax({
            type: "POST",
            dataType: "text",
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                location.reload();
            },
            error: function (err) {
                // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        })
    }
</script>

<script>
    $(document).on('click', '.accept', function() {
        $.ajax({
            type: "get",
            url: "<?php echo route('users.user.acceptedbyparent', $code); ?>",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function () {
                showLoader();
            },
            success: function (response) {
                hideLoader();
                swal(response.message, {
                    closeOnClickOutside: false,
                    text: "Approved Successfully!",
                    icon: "success",
                }).then(function() {
                    window.location.href = site_url;
                });
            },
            error: function (err) {
                // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        });

        return false;
    });

    $(document).on('click', '.reject', function() {
        $.ajax({
            type: "get",
            url: "<?php echo route('users.user.rejecteddbyparent', $code); ?>",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function () {
                showLoader();
            },
            success: function (response) {
                hideLoader();
                swal(response.message, {
                    closeOnClickOutside: false,
                    text: "Rejected Successfully!",
                    icon: "warning",
                }).then(function() {
                    window.location.href = site_url;
                });
            },
            error: function (err) {
                // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        });

        return false;
    });
</script>
@endpush