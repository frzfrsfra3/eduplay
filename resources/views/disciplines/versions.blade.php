<div id="no-more-tables" class="circulm_table mrgn-tp-30">
    <table class="versn_table table table-bordered table-condensed cf" cellpadding="0" cellspacing="0">
        <thead class="cf">
        <tr>
            <th>@lang('disciplines.version_number')</th>
            <th>@lang('disciplines.date')</th>
            <th>@lang('disciplines.comments')</th>
        </tr>
        </thead>
        <tbody>
            @foreach($discipline->disciplineversions as $value) 
                <tr>
                    <td data-title="Version Number">{{ $value['version'] }}</td>
                    <td data-title="Date" class="date">{{ date('d/m/Y',strtotime($value['created_at'])) }}</td>
                    <td data-title="Comments">{{ $value['comments'] }}</td>
                </tr>
            @endforeach 
        </tbody>
    </table>
</div>