@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/nestable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
    <style>

        div#pagination ul {
            margin: 0px ;

        }
        .panel{border:0}
    </style>


@endsection
@section('top')


    @include('myexercisesnavigation' ,[$ispublic])

@endsection
@section('content')

<div class="panel panel-default">

    <div class="container">
<div class="exerciseset-form" id="exerciseset-form">
        <div class="exerciseset-details col-xl-12 col-lg-12 col-sm-12 col-xs-12 le-padding" id="exerciseset-details">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding"  style="">
                    <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 header-title">Summary</div>
                    <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 header-bottun" >
                    @if (   $exerciseset->price==0   )
                    <a href="{{ route('practice.index', $exerciseset->id ) }}" class="btn btn-edubtn m2" title="@lang('exerciseset_show.practice_exerciseset')" >
                        Practice</a>
                    @endif

                        @if (   $exerciseset->price!=0   )
                            @cannot('showbuy' ,$exerciseset)
                            <a href="{{ route('practice.index', $exerciseset->id ) }}" class="btn btn-edubtn m2" title="@lang('exerciseset_show.practice_exerciseset')" >
                                Practice</a>
                            @endcannot
                        @endif

                    @if (  Auth::guest () && $exerciseset->price==0   )

                    <a href="#" data-url="{{ route('exercisesets.exerciseset.addtomylibrary', $exerciseset->id ) }}"
                       id="addtomylibrary" onclick="addtomylibrary()" class="btn btn-edubtn" title="Add to Private Library" >
                        Add to Private Library</a>
                    @endif

                    @can('addtoprivatelibrary' ,$exerciseset)
                    <a href="#" data-url="{{ route('exercisesets.exerciseset.addtomylibrary', $exerciseset->id ) }}"
                       id="addtomylibrary" onclick="addtomylibrary()" class="btn btn-edubtn" title="Add to Private Library" >
                            Add to Private Library</a>
                    @endcan
                    @if (  Auth::guest () && $exerciseset->price>0 )
                        <a href="{{ route('exercisesets.buyexercise', $exerciseset->id ) }}" class="btn btn-edubtn" title="Buy this Exerciseset" >
                            Buy</a>
                        @endif

                    @can('showbuy' ,$exerciseset)
                    <a href="{{ route('exercisesets.buyexercise', $exerciseset->id ) }}" class="btn btn-edubtn" title="Buy this Exerciseset" >
                        Buy</a>
                    @endcan
                        @if (   $exerciseset->price==0   )

                    <a id="showquestion" href="#" class="btn btn-edubtn" data-list_question="{{route ('exercisesets.exerciseset.listofquestion',$exerciseset->id)}}" title="View Questions" >
                        View Questions</a>
                            @endif
                        @if (   $exerciseset->price!=0   )
                        @cannot('showbuy' ,$exerciseset)
                            <a id="showquestion" href="#" class="btn btn-edubtn " data-list_question="{{route ('exercisesets.exerciseset.listofquestion',$exerciseset->id)}}" title="View Questions" >
                                View Questions</a>
                            @endcannot
                        @endif

                </div>
            </div>


            @include ('exercisesets.details', [
                                  'exerciseset' => $exerciseset,
                                ])


        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 "  id="questiondiv">   </div>
        @Auth
            @if ( Auth::user()->exercises->where('id','=' , $exerciseset->id)->first() ||  $exerciseset->price ==0 )

            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding star-rating exerci-head ">
                <div class="col-auto all-padding">
                Your Rate:</div>

                <div  class="col-xl-6 col-lg-6col-sm-6 col-xs-6 all-padding" >
                    <input id="srating" name="srating" class="rating rating-loading"
                        data-show-caption="false" data-show-clear="false" data-min="0" data-max="5" data-step="1" data-size="xs"
                        value="{!! $userrate !!}"   data-url="{{route ('exercisesets.exerciseset.addrate')}}">
                    <input  id="rateval" type="hidden" value="{!! $userrate !!}" >
                    <input type="hidden" id="exerciseset_id" value="{{$exerciseset->id}}">
                </div>

            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" ></div>


        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" >
            <form class="form-group">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding "><h5>Review:</h5>
                <div class="col-lg-12  commentform">
                <input type="text" name="title"   id="title" placeholder="Title"  >

                </div>
                <div class="col-lg-12 commentform ">
                    <textarea   rows="5" id="comment" style="width:100%;" placeholder="Your comment"></textarea>
                </div>
                <div class="col-lg-12 commentform ">
                <a href="#" id="addcomment" class="btn btn-rounded btn-edubtn" data-url="{{route('exercisesets.exerciseset.addreview')}}" >Add Comment</a>
                </div>
            </div>

            </form>
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12"></div>

        </div>
                @endif
        @EndAuth

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " >
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exerci-head" ><h5 style="color: black;">All Review:</h5>
                @foreach( $exerciseset->allreviews() as $rate )
                    <h6 style="margin-left: 20px">{{App\Models\User::findorfail($rate->author_id)->name}}
                 <b> {{$rate->title }} </b>: {{$rate->body}} <span style="float: right"> {{$rate->created_at }} </span></h6>

                @endforeach


            </div>
            <div class="col-lg-1"></div>

        </div>
    </div>
    </div>

</div>

@endsection

@section('footer_scripts')
    <script>
        function myFunction(val) {
            document.getElementById("timeslider").innerHTML = val;
        }
    </script>



    <script>
        var $star_rating1 = $('.all-star-rating .fa');
        var SetRatingStar = function() {
            return $star_rating1.each(function() {
                if (parseInt($star_rating1.siblings('input.avg-rating-value').val()) >= parseInt($(this).data('all-rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            });
        };
        SetRatingStar();
        $(document).ready(function() {
        });


    </script>
    <script type="text/javascript" src="{{ asset('assets/js/star-rating.js') }}"></script>
    <script type="text/javascript">
        $(document).on('ready', function(){
            $(".rating").rating().on("rating:change", function(event, value, caption) {
                var url=$('.rating').data("url");

                var title=$('#title').val();
                var comment=$('#comment').val();
                $('#rateval').val(value);
                var id=$('#exerciseset_id').val();
                 $.ajax({
                    url: url,
                    type: "post",
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "title":title,
                        "comment":comment,
                        value: value
                    },
                    success: function(response){ // What to do if we succeed
                    },
                    error: function(response){
                        console.log('Error'+response);
                    }
                });
            });
        });
    </script>
    <script>
        $("#addcomment").click( function()
            {
                var url=$('#addcomment').data("url");
                var id=$('#exerciseset_id').val();
                var title=$('#title').val();
                var comment=$('#comment').val();
                var value=$('#rateval').val();
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "title":title,
                        "comment":comment,
                        value: value
                    },
                    success: function(response){ // What to do if we succeed
                        location.reload();
                    },
                    error: function(response){
                        console.log('Error'+response);
                    }
                });
            }
        );



        function addtomylibrary() {

                var url=$('#addtomylibrary').data("url");
            @auth()
                $.ajax({
                    type: "post",
                    dataType: "text",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {



                        location.reload();
                        console.log(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                     //   console.log("AJAX error : " + JSON.stringify(err, null, 2));
                        console.log('jqXHR:');
                        console.log(jqXHR);
                        console.log('textStatus:');
                        console.log(textStatus);
                        console.log('errorThrown:');
                        console.log(errorThrown);
                    }
                })

            @endauth
            @guest()
            console.log('not loged');
            location.href='{{route('login')}}';
            @endguest
                }



        $("#showquestion").click( function()
            {
                var url=$('#showquestion').data("list_question");
                   $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'html',
                    data: {
                        "_token": "{{ csrf_token() }}",},
                    success: function(response){ // What to do if we succeed
                        $('#questiondiv').html(response);
                        //location.reload();
                    },
                    error: function(response){
                        console.log('Error 11'+response);
                    }
                });

            }
        );


        $(function() {
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                $('#load a').css('color', '#dfecf6');
               // $('#load').append('<img style="position: absolute; left: 20px;  max-width=50%;  max-height=50%; top: 0; z-index: 100000000;" src="/assets/images/loading__pagination_ajax.gif" />');
                var url = $(this).attr('href');

                getquestions(url);
              //  window.history.pushState("", "", url);
            });

            function getquestions(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                   // $('.articles').html(data);
                    $('#questiondiv').html(data);
                }).fail(function () {
                    alert('Questions could not be loaded.');
                });
            }
        });


    </script>




@endsection

