
@if ($skills ->count()<>0)


    <div class=" col-xl-4 col-lg-4 col-sm-6 col-xs-12  disipline_box">
    @php

        $color = array(
            1 => "#3ec1de",
            2 => "#49abe1",
            3 => "#5a87e5",
         /*   4=>  "#fab06a",
            5=>  "#8D614F",*/
            );
    @endphp
        @php
        if ($i==1)
        {$mainclass="disipline-box-inline-first" ;}
        else
        {$mainclass="disipline-box-inline" ;}

        @endphp



            <div  class="{{$mainclass}}" style="background-color: {{$color[rand(1,3)]}} ;min-height: 110px;">

        <div  style="padding:0 0 0 5px; ">
            <div class="skill_category_name  " >{{$skillcategory->skill_category_name}}
                {{--<span  class="count_skill_cat">   {{$skills->count().' Skills'}}</span>--}}
                <span  class="count_skill_cat">   {{$skillcategory->duration.' Hrs'}}</span>
            </div>

        </div>
        @foreach($skills as $skill)
            <div id="html_skill{{$skill->id}}"  class="skill_name"  >
                {{$skill->skill_name}}  {{--@include ('knowledgemap.oneskill', [ $skill,  ])--}}

            @if( $showgride==1 )
                <div id="html_skill{{$skill->id}}"  class="showgrade"  style="float: right">
                    {{$skill->get_gradename()}}  {{--@include ('knowledgemap.oneskill', [ $skill,  ])--}}
                </div>

                @endif
            </div>
        @endforeach

        <div class="clear-line"></div>
    </div>

</div>
@endif

