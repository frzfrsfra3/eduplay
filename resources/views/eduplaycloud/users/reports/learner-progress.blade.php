<div id="donutchart" style="width: 100%; height:300px"></div>
<div id="labelOverlay">
    <p class="used-size piecolor">{{ $learnerProgress[5]['Mastered'] }}<span>%</span></p>
    <p class="total-size piecolor"> @lang('reports.progress')</p>
</div>

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

<script>
<?php if (count($learnerProgress) > 0): ?>
var learnerProgress = <?php echo json_encode($learnerProgress); ?>;
<?php else: ?>
var learnerProgress = '';
<?php endif; ?>
</script>

<script>
$(document).ready(function() {
    $("#labelOverlay p").on("click", function() {
        var userId = $('.header').attr('id');
        var classId = $('#progress-class-select-picker').find('option:selected').val();
        window.location.href = site_url + '/reports/skill/performance/' + classId + '/' + userId;
    });
});
</script>

@endpush