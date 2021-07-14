<div id="html_skill{{$skill->id}}">

    @php
        $color = array(
            1 => "#3ec1de",
            2 => "#49abe1",
            3 => "#5a87e5",

            );

    @endphp


    <li id="cat{{$skill->id}}" data-paranet="parent{{$skillcategory->id}}"
        class="col-xl-12  col-md-12 col-sm-12 col-xs-12 list-group-item placeholder li-skill"
        style="background-color: {{$color[rand(1,3)]}};" data-id1="c{{$skill->id}}">

    <span id="i{{$skill->id}}" aria-hidden="true" class="icon-move skill-name-style">  {{ $skill->skill_name }}
        : </span>

        @if ( $skill->version ==  $lastversion  || $skill->createdby==Auth::user()->id  )
            <i id="spanbuton{{ $skill->id }}" type="button" style="font-size: 16px; width:12px;"
               data-edit-link="{{ route('collaborationController.skill.edit_modal', $skill->id) }}"
               data-toggle="modal"
               class="edit-button btn fa fa-pencil-square-o"
               data-target="#editskillModal" data-skill_id="{{$skill->id}}"
               onclick="edit_skill('{{ route('collaborationController.skill.edit_modal', $skill->id) }}')"></i>

            <form id="deleteform" name="deleteform" method="POST"
                  action="{!! route('collaborationController.skill.destroy', $skill->id) !!}"
                  accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <button id="deletebuton{{ $skill->id }}" type="submit"
                        data-delete-link=""
                        class="btn fa fa-trash delete-skill"
                        data-delete_skill_id=nav{{$skillcategory->id}}"
                        onclick="return confirm('Delete Skill?')"></button>



                </form>

                <br>
            <span>   {{$skill->skill_description}}</span>

        @endif
        <div class="cat-footer col-xl-12  col-md-12 col-sm-12 col-xs-12">
            <div class="col-xl-6  col-md-6 col-sm-12 col-xs-12">

                <i class="fa fa-user" aria-hidden="true"></i> {{$skill->getusername_createdby()}} |
                &nbsp
                v. {{$skill->version}}
            </div>
            <div class=" col-xl-1  col-md-1 col-sm-2 col-xs-2 clear-padding-left-right"
                 style="margin-top: 2px;text-align: right;float: right">

                @if (Auth::user ()->can ('coordinate', $discipline) && $skill->version>  $discipline->currentversion() )
                    <button id="accept_btn{{$skill->id}}" class="btn fa fa-times-circle   fa-lg acceptreject"
                            aria-hidden="true" title="Reject"
                            onclick="accept( '{{ route('publishing.skill.reject',[ $skill->id ,$discipline->id]) }}','{!! $skill->id !!}')"></button>

                    <button id="accept_btn{{$skill->id}}" class="btn fa fa-check-circle-o   fa-lg acceptreject"
                            aria-hidden="true" title="Accept"
                            onclick="reject( '{{ route('publishing.skill.accept',[ $skill->id ,$discipline->id]) }}','{!! $skill->id !!}')"></button>
                @endif </div>

            <div class="skill-cat-publish_status col-xl-1  col-md-1 col-sm-1 col-xs-1 clear-padding-left-right"
                 style="margin-top: 2px">     {{$skill->publish_status}}  </div>
            <div class="skill-cat-approve_status col-xl-1  col-md-1 col-sm-1 col-xs-1 clear-padding-left-right"
                 style="margin-top: 2px">  {{$skill->approve_status}} </div>



            @if ($skill->get_gradename()<>"")
                <div class="skill-cat-publish_status  col-xl-1  col-md-1 col-sm-1 col-xs-1 clear-padding-left-right"
                     style="margin-top: 2px"> {{$skill->get_gradename()}} </div>
            @endif


           {{-- @if ($skill->get_topicname()<>"")
                <div class="skill-cat-approve_status col-xl-1  col-md-1 col-sm-1 col-xs-1 clear-padding-left-right"
                     style="margin-top: 2px"> {{$skill->get_topicname()}} </div>
            @endif--}}


        </div>


        @php($skillchildren=$skill->getskillchildren( ) )

        @foreach($skillchildren as $skillchild)

            <div class="div-skillcategory-child  col-xl-12  col-md-12 col-sm-12 col-xs-12 ">
                <div id="div_skill_child" class="skill_child_div  ">
                                        <span id="span{{$skillchild->id}}">

                                                   <span id="i{{$skill->id}}" aria-hidden="true"
                                                         class="icon-move div-skillcategory-child-title"> -{{$skillchild->skill_name}}
                                                       :</span>
                                            @if ( $skillchild->updatedby ==Auth::user() ->id &&$skillchild->approve_status=='pending'  )
                                                <form id="deleteskillchildform" name="deleteskillchildform"
                                                      method="POST"
                                                      action="{!! route('collaborationController.skill.destroy', $skillchild->id) !!}"
                                                      accept-charset="UTF-8">
                                                 <input name="_method" value="DELETE" type="hidden">
                                                    {{ csrf_field() }}
                                                    <button id="deleteskillchildbuton{{ $skillchild->id }}"
                                                            type="submit" class="btn fa fa-trash delete-skill "
                                                            style="float: right"
                                                            onclick="return confirm('Delete Updated Skill  ?')">  </button>
                                               </form>
                                            @endif
                                            <br>
                                            {{$skillchild->skill_description}}


                                            <div class="cat-footer col-xl-12  col-md-12 col-sm-12 col-xs-12">


                                               <div class="col-xl-3  col-md-3 col-sm-12 col-xs-12">
                                               <i class="fa fa-user"
                                                  aria-hidden="true"></i>   &nbsp{{$skillchild->getusername_updateby()}}

                                                   &nbsp|   v.{{$skillchild->version}} </div>

                                             <div class="skill-btn col-xl-1 col-md-1 col-sm-5 col-xs-6 clear-padding-left-right"
                                                  style="margin-top: 4px">
                                                      @if (Auth::user ()->can ('coordinate', $discipline))
                                                     <button id="accept_btn{{$skillchild->id}}"
                                                             class="fa  fa-times-circle  fa-lg publishicon"
                                                             aria-hidden="true" title="Reject"
                                                             onclick="accept( '{{ route('publishing.skill.reject',[ $skillchild->id ,$discipline->id]) }}','{!! $skill->id !!}')"></button>
                                                     <button id="accept_btn{{$skillchild->id}}"
                                                             class="fa    fa-check-circle-o fa-lg publishicon"
                                                             aria-hidden="true" title="Accept"
                                                             onclick="reject( '{{ route('publishing.skill.accept',[ $skillchild->id ,$discipline->id]) }}','{!! $skill->id !!}')"></button>
                                                 @endif
                                                     </div>

                                                 <div class="skill-cat-publish_status  col-xl-1  col-md-1 col-sm-1 col-xs-6 clear-padding-left-right"
                                                      style="margin-top: 2px">   {{$skillchild->publish_status}}  </div>

                                                 <div class="skill-cat-approve_status  col-xl-1  col-md-1 col-sm-1 col-xs-6 clear-padding-left-right"
                                                      style="margin-top: 2px">    {{$skillchild->approve_status}} </div>

                                                @if ($skillchild->get_gradename()<>"")
                                                    <div class="skill-cat-publish_status  col-xl-1  col-md-1 col-sm-1 col-xs-6 clear-padding-left-right"
                                                         style="margin-top: 2px"> {{$skillchild->get_gradename()}} </div>
                                                @endif
                                                @if ($skillchild->get_topicname()<>"")
                                                    <div class="skill-cat-approve_status col-xl-1  col-md-1 col-sm-1 col-xs-6 clear-padding-left-right"
                                                         style="margin-top: 2px"> {{$skillchild->get_topicname()}} </div>
                                                @endif






                                            </div>
                                    </span>
                </div>
            </div>

        @endforeach

    </li>
</div>
