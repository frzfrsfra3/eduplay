@extends('authenticated.layouts.default')
@section('header_styles')
<link href="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.css')}}" />
@stop
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
<div class="container">
   <div class="row justify-content-center">
      <div class="col-xl-11">
         <div class="mrgn-tp-30 text-ar-right">
            <nav aria-label="tp-breadcm" class="tp-breadcm">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">@lang('messages.my_reviews')</li>
               </ol>
            </nav>
            <div class="main_summery_earth">
               <div class="clearfix"></div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="review_section2">
                        <div class="row">
                           <div class="col-xl-12">
                              <div class="inner_review_section">
                                 <div class="row">
                                    <div class="col-lg-12 col-xl-12">
                                        <div id="results">
                                       <div class="rating_view_detail" >
                                          @foreach($ratings as $ratekey => $item)
                                          <div class="rew_prfl_sectin after_{{$ratekey}}">
                                             <div class="prfl_img">
                                                @if ($item->reviewrateable_type == 'App\Models\Courseclass')     
                                                    <img src="{{asset('assets/images/')}}/{{  $item['ratings_data']['image'] }}">
                                                @elseif ($item->reviewrateable_type == 'App\Models\Game')
                                                    <img src="{{ asset('assets/eduplaycloud/image/game_8.png') }}"/>
                                                @elseif ($item->reviewrateable_type == 'App\Models\Exerciseset')
                                                    <img src="{{ asset('uploads/exercisesets/')}}/{{  $item['ratings_data']['image'] }}"/>
                                                @endif
                                                
                                             </div>
                                             <div class="rate_date">
                                                <div class="title_star">
                                                <h6>
                                                    @if ($item->reviewrateable_type == 'App\Models\Game') 
                                                        <a style='color: inherit !important;' href="{{ route('games.game.show',$item['ratings_data']['id'])}}">{{@$item['ratings_data']['name']}}</a>
                                                    @elseif ($item->reviewrateable_type == 'App\Models\Courseclass') 
                                                        <a style='color: inherit !important;' href="{{ route('courseclasses.courseclass.show',$item['ratings_data']['id'])}}">{{@$item['ratings_data']['name']}}</a>
                                                    @elseif ($item->reviewrateable_type == 'App\Models\Exerciseset') 
                                                        <a style='color: inherit !important;' href="{{ route('exercisesets.exerciseset.show',array($item['ratings_data']['id'],1)) }}">{{@$item['ratings_data']['name']}}</a>
                                                    @endif
                                                    
                                                </h6>
                                                   <div class="gray_star">
                                                      <div class="orng_star" style="width: {{(@$item['ratings_data']['rate']) * 100 / 5}}%;"></div>
                                                   </div>
                                                </div>
                                                <div class="date_frmt">
                                                   <span>{{@\Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</span>
                                                </div>
                                             </div>
                                             <p>{{@$item->body}}</p>
                                          </div>
                                          @endforeach
                                          
                                       </div>
                                        </div>
                                       <div class="wrapper">
                                            
                                            <div class="ajax-loading"><img src="{{ asset('assets/eduplaycloud/image/loader.gif') }}" /></div>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
        $('.ajax-loading').hide();
        var page = 1; //track user scroll as page number, right now page number is 1
        $(window).scroll(function() { //detect page scroll
           
            if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
                page++; //page number increment
                load_more(page); //load content   
            }
        });     
        function load_more(page){
          $('#no_records').html(" ");
          $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                    beforeSend: function()
                    {
                        $('.ajax-loading').show();
                    }
                })
                .done(function(data)
                {
                  if(data == 0){ // If no record found
                     $('#results').append("<font color='red'>@lang('messages.no_more_reviews')</font>");
                     $('#view_more_link').hide();
                     return false;
                  } else {
                     $('.ajax-loading').hide(); //hide loading animation once data is received
                     $("#results").append(data); //append data into #results element          
                  }         
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                      alert('No response from server');
                });
         }
        </script>
@endpush
@endsection