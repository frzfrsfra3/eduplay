<li id="cat{{$skill->id}}" class="list-group-item" class="placeholder"  style="margin-bottom: 5px">
    <div class="underlined_div">
    <i id="i{{$skill->id}}" class="fa fa-th-list" aria-hidden="true"
       class="icon-move"><b>  {{ $skill->skill_name }} :</b> </i>
    <br>
    {{$skill->skill_description}}
    <footer>
        <small> created by : {{$skill->getusername_createdby()}}
            <mark>
                version: {{$skill->version}}</mark>
            <code> {{$skill->get_gradename()}} </code>
            <code class=" btn-info"> {{$skill->get_topicname()}} </code>
            <code>    {{$skill->publish_status}}  </code>
            <mark>   {{$skill->approve_status}} </mark>
        </small>
        @if ( $skill->version >  $lastversion && $skill->approve_status =='pending'   )
            <button id="accept_btn{{$skill->id}}" type="button" title="Accept"
                    class="accept-button btn btn-info btn-circle"
                    onclick="accept( '{{ route('publishing.skill.accept',[ $skill->id ,$disciplineid]) }}',{!! $skill->id !!})">
                <i class="">Accept</i>
            </button>

            <button id="reject_btn{{$skill->id}}" type="button" title="Reject"
                    class="reject-button btn btn-info btn-circle"
                    onclick="reject( '{{ route('publishing.skill.reject',[ $skill->id ,$disciplineid]) }}',{!! $skill->id !!})">
                <i class="">Reject</i>
            </button>
        @endif

    </footer>
    </div>
    @php($skillchildren=$skill->getskillchildren( ) )

    @foreach($skillchildren as $skillchild)
        <br>
        <span id="span{{$skillchild->id}}">

                                                   <i id="i{{$skill->id}}" class="far fa-edit" aria-hidden="true"
                                                      class="icon-move"><b>-> {{$skillchild->skill_name}} :</b> </i><br>
            {{$skillchild->skill_description}}


            <footer>
                                            <small>   edit by:{{$skillchild->getusername_updateby()}}</small>
                                           <small>
                                                <mark>     version: {{$skillchild->version}}  </mark>
                                                  <code>    {{$skillchild->publish_status}}  </code>
                                                   <mark>   {{$skillchild->approve_status}} </mark>

                                                </small>
                                        @if ( $skillchild->approve_status =='pending'   )

                                        <button id="accept_btn{{$skillchild->id}}" type="button" title="Accept"
                                                class="accept-button btn btn-info btn-circle"
                                                onclick="accept( '{{ route('publishing.skill.accept',[ $skillchild->id ,$disciplineid]) }}',{!! $skill->id !!})">
                                            <i class="">Accept</i>
                                        </button>

                              <button id="reject_btn{{$skillchild->id}}" type="button" title="Reject"
                                 class="reject-button btn btn-info btn-circle"
                                    onclick="reject( '{{ route('publishing.skill.reject',[ $skillchild->id ,$disciplineid]) }}',{!! $skill->id !!})">
                                            <i class="">Reject</i>
                                        </button>


                                            @endif
                 </footer>




                                    </span>

    @endforeach

</li>

