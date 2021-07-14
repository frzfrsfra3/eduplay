
                </div>
            </div>
            <div>
                <div class="div-carousel-home">
                    <div><img class="img-carousel" src="{{ asset('assets/images/') }}/image5a5632609552a_math.jpg"></div>
                    <div class="div-carousel-title-3">My Library <p class="div-carousel-txt-3">dvfbg</p></div>

                </div>
            </div>
            <div>
                <div class="div-carousel-home">
                    <div><img class="img-carousel" src="{{ asset('assets/images/') }}/image5a5632609552a_math.jpg"></div>
                    <div class="div-carousel-title-3">My Library <p class="div-carousel-txt-3">dvfbg</p></div>

      <div class="badges_images"><img src="{{ asset('assets/images/badges/'.$uimg) }}"></div>
           <div class="badges_date"  style="padding-left: 15px;padding-right: 15px">@lang('home.date_acquired') : {{date('d - M - Y', strtotime( $allbadges->pivot->dateacquired ))}}</div>


        <div style="clear:both; padding-top: 30px; padding-left: 15px;padding-right: 15px">
        <ul> @if(count($pendings) == 0)
                <div class="panel-body text-center">
                    <h4>No Pending Tasks Available!</h4>
                </div>
        </ul>
            </div>
            <div>
                <div class="div-carousel-home">
                    <div><img class="img-carousel" src="{{ asset('assets/images/') }}/image5a5632609552a_math.jpg"></div>
                    <div class="div-carousel-title-3">My Library <p class="div-carousel-txt-3">dvfbg</p></div>

                </div>
            </div>
        </div>
        <!-- End Part4 -->
    </div>
    <div class="col-md-3" style="background: #fafafa;">
        <div><img src="{{ asset('assets/images/') }}/profile.png"></div>
        <div class="btn-greenbutton-homepage">Update Profile</div>
        <div style="clear:both; padding-top: 30px;">
        <ul>
            <li>
                <a href="#">
                <div class="hexagon">
                    <div class="hexagontext"></div>
                </div>
                <span>Get to know EduPlayCloud</span>
                <i class="fa fa-angle-right rounded-arrow-align" aria-hidden="true"></i>
                </a>
            </li>

            <li><a href="#">
                    <div class="hexagon">
                        <div class="hexagontext"></div>
                    </div>
                    <span>Complete Profile</span>
                    <i class="fa fa-angle-right rounded-arrow-align" aria-hidden="true"></i>
                </a></li>
            <li><a href="#">
                    <div class="hexagon">
                        <div class="hexagontext"></div>
                    </div>
                    <span> Add Class</span>
                    <i class="fa fa-angle-right rounded-arrow-align" aria-hidden="true"></i>
                </a></li>
            <li><a href="#">
                    <div class="hexagon">
                        <div class="hexagontext"></div>
                    </div>
                    <span>Add Study Set to Library</span>
                    <i class="fa fa-angle-right rounded-arrow-align" aria-hidden="true"></i>
                </a></li>
            <li><a href="#">
                    <div class="hexagon">
                        <div class="hexagontext"></div>
                    </div>
                    <span>Share EduPlayCloud</span>
                    <i class="fa fa-angle-right rounded-arrow-align" aria-hidden="true"></i>
                </a></li>
        </ul>
        </div>

    </div>
</div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/homepage.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-tour.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection