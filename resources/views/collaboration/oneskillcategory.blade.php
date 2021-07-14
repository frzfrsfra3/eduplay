@php
    $color = array(
        1 => "#3ec1de",
        2 => "#49abe1",
        3 => "#5a87e5",

        );

@endphp


<a herf="" data-a_skillcategoryid="{{$skillcategory->id}}" class="a_cat" style="color:inherit; text-decoration:none ;">

    @if($i==1)
        <li class="col-md-12 col-sm-12 col-xs-12 placeholder skill_cat_collaboration_first" id="skillcategory{{$skillcategory->id}}}"
            style="background-color: {{$color[rand(1,3)]}};">
    @else
        <li class="col-md-12 col-sm-12 col-xs-12 placeholder skill_cat_collaboration" id="skillcategory{{$skillcategory->id}}}"
            style="background-color: {{$color[rand(1,3)]}};">
            @endif

            <span>{{$skillcategory ->skill_category_name }}</span>
            @if ( $skillcategory->version ==  $lastversion  || $skillcategory->createdby==Auth::user() ->id  )

                <i id="cat_btn{{$skillcategory->id}}" type="button" style="font-size: 16px; width:12px; "
                   data-skillcategoryedit-link="{{ route('collaborationController.skillcategory.edit_skillcategory_modal', $skillcategory->id) }}"
                   data-toggle="modal"
                   class="edit-skillcategorybutton btn fa fa-pencil-square-o"
                   data-target="#editskillcategoryModal" data-skill_category_id="{{$skillcategory->id}}"
                   onclick="edit_skill_category('{{ route('collaborationController.skillcategory.edit_skillcategory_modal', $skillcategory->id) }}')"></i>
                <form id="deleteskillcategoryform" name="deleteskillcategoryform" method="POST"
                      action="{!! route('collaborationController.skillcategory.destroy', $skillcategory->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <button id="deleteskillcategorybuton{{ $skillcategory->id }}" type="submit"
                            class="btn fa fa-trash delete-skill-category "
                            onclick="return confirm('Delete Skill Category ?')"></button>
                </form>
            @endif

                <div class="cat-footer ">



                    <div class=" clear-padding-left-right  col-md-12 col-sm-12 col-xs-12">
                    <i class="fa fa-user" aria-hidden="true"></i> {{$skillcategory->getusername_createdby()}}&nbsp|

                        v. {{$skillcategory->version}} </div>
                    <div class="skill-cat-btn clear-padding-left-right col-md-2.5 col-sm-2.5 col-xs-2.5">
                        @if (Auth::user ()->can ('coordinate', $discipline) && $skillcategory->version>  $discipline->currentversion() )
                            <button id="reject_cat_btn{{$skillcategory->id}}"
                                    class="fa fa-times-circle fa-2x publishicon" aria-hidden="true" title="Reject"
                                    onclick="reject_category( '{{ route('publishing.skillcategory.rejectskillcategory',[ $skillcategory->id ,$discipline->id,$i]) }}','{!! $skillcategory->id !!}')">
                            </button>

                            <button id="accept_cat_btn{{$skillcategory->id}}"
                                    class="fa fa-check-circle-o  fa-2x  publishicon" aria-hidden="true" title="Accept"
                                    onclick="accept_category( '{{ route('publishing.skillcategory.acceptskillcategory',[ $skillcategory->id ,$discipline->id,$i] ) }}','{!! $skillcategory->id !!}')">
                            </button>


                        @endif
                    </div>
                    <div class="skill-cat-publish_status  col-md-2 col-sm-2 col-xs-2">    {{$skillcategory->publish_status}}  </div>
                    <div class="skill-cat-approve_status  col-md-2 col-sm-2 col-xs-2">   {{$skillcategory->approve_status}} </div>


                </div>



            @php($skillcategorychildren=$skillcategory->getchildren( ) )
            @foreach($skillcategorychildren as $skillcategorychild)

                <div class=" div-skillcategory-child col-md-12 col-sm-12 col-xs-12">

        <span class="div-skillcategory-child-title " id="span{{$skillcategorychild->id}}">
            {{$skillcategorychild->skill_category_name}}: </span>

                    @if ( $skillcategorychild->updatedby ==Auth::user() ->id && $skillcategorychild->approve_status=='pending'  )
                        <form id="deleteskillcategorychildform" name="deleteskillcategoryform" method="POST"
                              action="{!! route('collaborationController.skillcategory.destroy', $skillcategorychild->id) !!}"
                              accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}
                            <button id="deleteskillcategorychildbuton{{ $skillcategorychild->id }}" type="submit"
                                    class="btn fa fa-trash delete-skill-category "
                                    style="float: right" onclick="return confirm('Delete Skill Category ?')"></button>
                        </form>
                    @endif

                    {{$skillcategorychild->skill_category_decsription}}


                    <div class="clear-padding-left-right  col-md-12 col-sm-12 col-xs-12">

                        <small style="font-size: 10px;">
                            <div class="  col-md-12 col-sm-12 col-xs-12">
                            <i class="fa fa-user"    aria-hidden="true"></i> {{$skillcategorychild->getusername_updateby()}}
                            &nbsp|
                            v.{{$skillcategorychild->version}}
                            </div>
                            <div class=" clear-padding-left-right  col-md-2 col-sm-2.5 col-xs-2.5" style="float: right">
                                @if (Auth::user ()->can ('coordinate', $discipline))

                                    <button id="reject_cat_btn{{$skillcategorychild->id}}"
                                            class="fa fa-times-circle  fa-lg publishicon" aria-hidden="true" title="Reject"
                                            onclick="reject_category( '{{ route('publishing.skillcategory.rejectskillcategory',[ $skillcategorychild->id ,$discipline->id ,$i]) }}','{!! $skillcategory->id !!}')">
                                    </button>

                                    <button id="accept_cat_btn{{$skillcategorychild->id}}"
                                            class="fa fa-check-circle-o  fa-lg publishicon" aria-hidden="true"
                                            title="Accept"
                                            onclick="accept_category( '{{ route('publishing.skillcategory.acceptskillcategory',[ $skillcategorychild->id ,$discipline->id ,$i]) }}','{!! $skillcategory->id !!}')">

                                    </button>

                                @endif
                            </div>

                            <div class=" col-md-3 col-sm-2 col-xs-2  skill-cat-publish_status">    {{$skillcategorychild->publish_status}} </div>
                            <div class=" col-md-3 col-sm-2 col-xs-2 skill-cat-approve_status">    {{$skillcategorychild->approve_status}} </div>


                        </small>

                    </div>

                </div>
                <div style="height:5px; clear:both;">&nbsp;</div>
            @endforeach

        </li></a>


<!-- Modal --------------------------------------------------------------------------------------------------------------------------------------->
<div class="modal fade" id="editskillcategoryModal" role="dialog">
    @include ('collaboration.editskillcatmodalform')
</div>
<!-- Modal ---------------------------------------------------------------------------------------------------------------------------------------------->


