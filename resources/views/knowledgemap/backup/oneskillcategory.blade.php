<a herf="" data-a_skillcategoryid="{{$skillcategory->id}}" class="a_cat" style="color:inherit; text-decoration:none">
    <li class="list-group-item" class="placeholder" id="skillcategory{{$skillcategory->id}}}">
        <i class="fa fa-th-list" aria-hidden="true" class="icon-move">
            <span>{{$skillcategory ->skill_category_name }}</span>

        </i>


        @php($skillcategorychildren=$skillcategory->getchildren( ) )
        @foreach($skillcategorychildren as $skillcategorychild)

            <div class="div-skillcategory-child ">
        <span style="font-size: 16px" id="span{{$skillcategorychild->id}}">
                                                 <b>  {{$skillcategorychild->skill_category_name}}:</b>

            <br>
            {{$skillcategorychild->skill_category_decsription}}



                                    </span>
            </div>
            <div style="height:5px; clear:both;">&nbsp;</div>
        @endforeach

    </li>
</a>



