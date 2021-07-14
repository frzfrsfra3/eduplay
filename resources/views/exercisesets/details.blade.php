<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box" style="">

    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-title"> {{ $exerciseset->title }}</div>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">

            <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 exercise-description"> {!!  nl2br($exerciseset->description)  !!}</div>
        </div>
        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">


        </div>
    </div>


    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-gray">
            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                    <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 title">Discipline's Curriculum :</div>
                <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-8 title-des"> {{ optional($exerciseset->discipline)->discipline_name }}</div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Grade :</div>
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des"> {{ optional($exerciseset->grade)->grade_name }}</div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                    <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Language :</div>
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des"> {{ optional($exerciseset->language)->language }}</div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Price :</div>
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des">$ {{ $exerciseset->price }}</div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Updated  :</div>
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des"> {{ $exerciseset->updated_at }}</div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
                <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Status :</div>
                <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des"> {{ $exerciseset->publish_status }}</div>

            </div>
        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
            <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-4 title">Author :</div>
            <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-8 title-des"> {{ ($exerciseset->owner)->name }}</div>

        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 rate">All Rates:
                <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 1) fa-star @else fa-star-o fa-star-default @endif " data-all-rating="1"></span>
                <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 2) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="2"></span>
                <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 3) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="3"></span>
                <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 4) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="4"></span>
                <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 5) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="5"></span>

            </div>


        </div>
    </div>
</div>