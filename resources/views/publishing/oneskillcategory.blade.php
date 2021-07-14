

@if($message_text<>'')
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-ok"></span>
        {!! $message_text !!}

        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
@endif



<li class="list-group-item" class="placeholder" id="skillcategory{{$skillcategory->id}}}">
    <i class="fa fa-th-list" aria-hidden="true" class="icon-move">
        <b>  {{$skillcategory ->skill_category_name }} :</b> <br> {{$skillcategory ->skill_category_decsription }}

    </i>
    <footer>
        <small> created by : {{$skillcategory->getusername_createdby()}}
            <mark><br>
                version: {{$skillcategory->version}}</mark>
            <code>    {{$skillcategory->publish_status}}  </code>
            <mark>   {{$skillcategory->approve_status}} </mark>
        </small>
        @if ( $skillcategory->version >  $lastversion && $skillcategory->approve_status =='pending'   )

            <button id="accept_cat_btn{{$skillcategory->id}}" type="button" title="Accept"
                    class="accept-button btn btn-info btn-circle"
                    onclick="accept_category( '{{ route('publishing.skillcategory.acceptskillcategory',[ $skillcategory->id ,$disciplineid]) }}',{!! $skillcategory->id !!})">
                <i class="">Accept</i>
            </button>

            <button id="reject_cat_btn{{$skillcategory->id}}" type="button" title="Reject"
                    class="reject-button btn btn-info btn-circle"
                    onclick="reject_category( '{{ route('publishing.skillcategory.rejectskillcategory',[ $skillcategory->id ,$disciplineid]) }}',{!! $skillcategory->id !!})">
                <i class="">Reject</i>
            </button>
        @endif
    </footer>
    @php($skillcategorychildren=$skillcategory->getchildren( ) )
    @foreach($skillcategorychildren as $skillcategorychild)
        <br>
        <span id="span{{$skillcategorychild->id}}">
            -> {{$skillcategorychild->skill_category_name}}
            <footer>
       <small>   edit by:{{$skillcategorychild->getusername_updateby()}}</small>
         <small>
         <mark>     version: {{$skillcategorychild->version}}  </mark>
          <code>    {{$skillcategorychild->publish_status}}  </code>
           <mark>   {{$skillcategorychild->approve_status}} </mark>
          </small>
                @if ( $skillcategorychild->approve_status =='pending'   )

                    <button id="accept_cat_btn{{$skillcategorychild->id}}" type="button" title="Accept"
                            class="accept-button btn btn-info btn-circle"
                            onclick="accept_category( '{{ route('publishing.skillcategory.acceptskillcategory',[ $skillcategorychild->id ,$disciplineid]) }}',{!! $skillcategory->id !!})">
                                            <i class="">Accept</i>
                                        </button>

                    <button id="reject_cat_btn{{$skillcategorychild->id}}" type="button" title="Reject"
                            class="reject-button btn btn-info btn-circle"
                            onclick="reject_category( '{{ route('publishing.skillcategory.rejectskillcategory',[ $skillcategorychild->id ,$disciplineid]) }}',{!! $skillcategory->id !!})">
                                            <i class="">Reject</i>
                                        </button>


                @endif

         </footer>
        </span>

    @endforeach
</li>




