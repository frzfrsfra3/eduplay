<div class="list_of_Collabrators">
    <div class="row">
        <div class="col-lg-12 col-xl-8">
    <h4>@lang('disciplines.collabrators')</h4>
    <div class="collarbl_table table-responsive">
        <table class="table" cellpadding="0" cellspacing="0">
            <tbody>
            @foreach($discipline->disciplinecollaborators as $value)    
            <tr>
                <td>
                    <div class="stdnt_nme">
                        @if ($value['user_image'] != "") 
                            <img height="60px;" width="60px;" style="border-radius:50%" src="{{ asset('assets/images/profiles') }}/{{  $value['user_image'] }}">
                        @else
                            <img height="60px;" width="60px;" style="border-radius:50%" src="{{ asset('uploads/profile/profile_img.jpg') }}"/>
                        @endif
                    <span class="name"> {{ $value['name'] }}</span>
                    </div>
                </td>
                <td>{{ $value['email'] }}</td>
                <td class="date">{{ date('d/m/Y',strtotime($value->pivot['created_at'])) }}</td>
                <td>
                    @if ($value->pivot['approvalstatus'] == 'pending') 
                        <span class="pendding_text"> 
                            @lang('disciplines.pending')
                        </span>    
                        <div class="request_cls">
                            <button type="button" class="accept-request"></button>
                            <button type="button" class="cancel-request"></button>
                        </div>
                    @elseif ($value->pivot['approvalstatus'] == 'approved')
                        <span class="done_text"> 
                            @lang('disciplines.approved')
                        </span>
                    @else 
                        <span class="declined_text"> 
                            @lang('disciplines.declined')
                        </span>
                    @endif
                
                    
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>