@if(count($pendingtasks) > 0)

<style>
        .no-more-tbl-task table{width: 100%;}
       .no-more-tbl-task table tr th{
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #000000;
       }
       .no-more-tbl-task table tr th, .no-more-tbl-task table tr td {
        border-bottom: 1px solid #e7e7e7;
        padding: 12px 15px 12px 15px;
        vertical-align: top;
    }
    .no-more-tbl-task table tr td {
        font-family: 'Raleway', sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #000000;
    }
    .no-more-tbl-task table tr td:first-child{
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
    }
        @media only screen and (max-width: 800px) {
    
            /* Force table to not be like tables anymore */
            #no-more-tables table, 
            #no-more-tables thead, 
            #no-more-tables tbody, 
            #no-more-tables th, 
            #no-more-tables td, 
            #no-more-tables tr { 
                display: block; 
            }
         
            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
         
            #no-more-tables tr { border: 1px solid #ccc; }
         
            #no-more-tables td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                white-space: normal;
                text-align:left;
            }
         
            #no-more-tables td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }
         
            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }
        }
</style>

    <div id="no-more-tables" class="no-more-tbl-task">
        <table class="table-condensed cf">
            <thead class="cf">
                <tr>
                    <th>@lang('messages.time')</th>
                    <th>@lang('messages.task_description')</th>
                    <th class="numeric">@lang('messages.sender_name')</th>
                    <th class="numeric">@lang('messages.status')</th>
                    <th class="numeric">@lang('messages.date')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingtasks as $pendingtask)
                    <tr>
                        <td data-title="@lang('messages.time')">{{ \Carbon\Carbon::parse($pendingtask->created_at)->format('h:m A') }}</td>
                        <td data-title="@lang('messages.task_description')">
                            @if($pendingtask->pending_task_description == 'Invite your friend to use Eduplaycloud')
                                <a href="" data-toggle="modal" data-target="#myModal" target="_blank">{{ucfirst($pendingtask->pending_task)}}</a>
                            @else
                                {{--  after production changes(CR) - done except exam task   --}}

                                @php

                                    $extra = "";
                                    if(strtolower($pendingtask->pending_task_description) === 'invite learners' ){
                                        $url= url($pendingtask->pending_task_action).'#Learners';
                                    }
                                    elseif(strtolower($pendingtask->pending_task_description) == strtolower('Add an exercise set to your class')){
                                        $url= url($pendingtask->pending_task_action).'#resources';
                                    }
                                    elseif(strtolower($pendingtask->pending_task_description) == strtolower('Action needed for enroll request')){
                                        $url= url($pendingtask->pending_task_action).'#learners';
                                    }
                                    elseif(strtolower($pendingtask->pending_task_description) == strtolower('Accept parent request')){
                                        $url= route('approveParentRequest' , $pendingtask->pending_task_action);
                                        $extra = " by " . $pendingtask->sender->name;
                                    }
                                    else{
                                        $url= url($pendingtask->pending_task_action);
                                    }

                                @endphp
                                <a href="{{ $url }}" target="_blank">{{ucfirst($pendingtask->pending_task . $extra)}}</a>
                                {{--  <a href="{{ url($pendingtask->pending_task_action) }}" target="_blank">{{ucfirst($pendingtask->pending_task)}}</a>  --}}
                            @endif
                        </td>
                        <td data-title="@lang('messages.sender_name')" class="numeric">
                            @if($pendingtask->sender == "")
                            -
                            @else 
                            {{ $pendingtask->sender->name }}
                            @endif
                            {{--  {{ $pendingtask->sender }}
                            {{ optional($pendingtask->sender)->name }}  --}}
                        </td>
                        <td data-title="@lang('messages.status')" class="numeric">{{ ucfirst($pendingtask->status) }}</td>
                        <td data-title="@lang('messages.date')" class="numeric">{{ \Carbon\Carbon::parse($pendingtask->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-md-12">
        <div class="float-right">
            {{ $pendingtasks->links() }}
        </div>
    </div>
@else
    <li>
        <div class="col-lg-12">
            <P>@lang('messages.no_data_found')!</P>
        </div>
    </li>
@endif