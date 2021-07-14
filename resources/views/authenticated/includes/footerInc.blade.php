<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="{{ asset('assets/eduplaycloud/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/js/jquery.CalendarHeatmap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/js/custom.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/freshslider.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.js" />
<script>
    $(function () {
        $('#langselector').on('change', function() {
            var url = $(this).val();
            if (url) {
                $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(err) {

                    }
                });
            }
            return false;
        });
    });
</script>
@stack('inc_script')

@stack('inc_jquery')

