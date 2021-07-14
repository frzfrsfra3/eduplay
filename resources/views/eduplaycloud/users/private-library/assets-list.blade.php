<div id="csv" class="hide inner-mdl-editr">
    <div id="no-more-tables-tabs" class="main-table">
        <table class="col-md-12 table-condensed cf">
            <thead class="cf">
                <tr>
                    <th>@lang('myassest.name')</th>
                    <th>@lang('myassest.uploaded_date')</th>
                    <th>@lang('myassest.file_size')</th>
                    <th>@lang('myassest.action')</th>
                </tr>
                <tr><th class="bg-none" colspan="4"></th></tr>
            </thead>
            <tbody>
                @if(count($csvs) > 0)
                    @foreach($csvs as $csv)
                        @php $path_parts = new  SplFileInfo($csv); @endphp
                        <tr>
                            <td data-title="@lang('myassest.name')"><img class="icn-left" src="{{ asset('assets/eduplaycloud/image/csv-img.png')}}">{{ $csv->getFilename() }}</td>
                            <td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$csv->getCTime()) }}</td>
                            <td data-title="@lang('myassest.file_size')">{{ round($csv->getSize()/1024)  }} Kb</td>
                            <td data-title="@lang('myassest.action')">
                                <button class="btn btn-warning" data-src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/csv') }}/{{ $path_parts->getFilename() }}" data-filename="{{ $path_parts->getFilename() }}" data-type="audio"  data-dismiss="modal" onclick="selectReplacePluginValue(this)">@lang('simple_editor.select')</button>
                            </td>
                        </tr>
                    @endforeach
                @else 
                    <tr>
                        <td colspan="4">
                           @lang('simple_editor.no_csv_uploaded') 
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<!----audio--->
<div id="audio" class="hide inner-mdl-editr">
    <div id="no-more-tables-tabs" class="main-table">
        <table class="col-md-12 table-condensed cf">
            <thead class="cf">
                <tr>
                    <th>@lang('myassest.name')</th>
                    <th>@lang('myassest.play')</th>
                    <th>@lang('myassest.uploaded_date')</th>
                    <th>@lang('myassest.file_size')</th>
                    <th>@lang('myassest.action')</th>
                </tr>
                <tr><th class="bg-none" colspan="4"></th></tr>
            </thead>
            <tbody>
                @if(count($audio) > 0)
                    @foreach($audio as $adio)
                        @php $path_parts = new  SplFileInfo($adio); @endphp
                    <tr>
                        <td data-title="@lang('myassest.name')">
                            <img class="audio-icn-left" src="{{ asset('assets/eduplaycloud/image/audio-img.png')}}">{{ $path_parts->getFilename() }}
                        </td>
                        <td data-title="@lang('myassest.play')">
                            <audio controls>
                                <source src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/audio') }}/{{ $path_parts->getFilename() }}" type="audio/mpeg">
                            </audio>
                        </td>
                        <td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$path_parts->getCTime()) }}</td>
                        <td data-title="@lang('myassest.file_size')">{{ round($path_parts->getSize()/1024) }} Kb</td>
                        <td  data-title="@lang('myassest.action')">
                            <button class="btn btn-warning" data-src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/audio') }}/{{ $path_parts->getFilename() }}" data-filename="{{ $path_parts->getFilename() }}" data-type="audio"  data-dismiss="modal" onclick="selectReplacePluginValue(this)">@lang('simple_editor.select')</button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            @lang('simple_editor.no_audio_uploaded') 
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<!----Images--->
<div id="image" class="hide inner-mdl-editr">
    <div id="no-more-tables-tabs" class="main-table">
        <table class="col-md-12 table-condensed cf">
            <thead class="cf">
                <tr>
                    <th>@lang('myassest.name')</th>
                    <th>@lang('myassest.uploaded_date')</th>
                    <th>@lang('myassest.file_size')</th>
                    <th>@lang('myassest.action')</th>
                </tr>
            <tr><th class="bg-none" colspan="4"></th></tr>
            </thead>
            <tbody>
            @if(count($images) > 0)
                @foreach($images as $image)
                    @php $path_parts = new  SplFileInfo($image); @endphp
                <tr>
                    <td data-title="@lang('myassest.name')">
                        <img class="only-img-ast" src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/image') }}/{{ $path_parts->getFilename() }}"/>
                    </td>
                    <td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$path_parts->getCTime()) }}</td>
                    <td data-title="@lang('myassest.file_size')">{{ round($path_parts->getSize()/1024) }} Kb</td>
                    <td data-title="@lang('myassest.action')">
                        <button class="btn btn-warning" data-src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/image') }}/{{ $path_parts->getFilename() }}" data-filename="{{ $path_parts->getFilename() }}" data-type="image"  data-dismiss="modal" onclick="selectReplacePluginValue(this)">@lang('simple_editor.select')</button>
                    </td>
                </tr>
                @endforeach
            @else 
                <tr>
                    <td colspan="4"> 
                        @lang('simple_editor.no_image_uploaded')
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

