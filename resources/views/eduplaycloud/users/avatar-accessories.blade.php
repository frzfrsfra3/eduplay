<!-- Slider -->
<div class="row">
    @if ($accessories->isNotEmpty())
        <div class="col-sm-8 col-md-9">
            <div  id="slider">
                <div class="row">
                    <div class="padn_40_rght col-sm-12" id="carousel-bounding-box">
                        <div class="carousel slide slider_garry_thumb" id="myCarousel">
                            <div class="carousel-inner">
                                @foreach ($accessories as $key => $value)
                                    @if ($key == 0) 
                                        @php
                                            $class = 'active';
                                        @endphp
                                    @else 
                                        @php
                                            $class = '';
                                        @endphp
                                    @endif
                                    
                                    <div class="{{ $class }} carousel-item" id="slide_{{ $key }}"  data-slide-number="{{ $key }}" data-avatar_accessories_id=" {{ $value->id }} " >
                                        @if ($userTotalPoints >= $value->points)
                                            <div class="point_earn red slider_avtr_blk">
                                                <img src="{{ asset('assets/eduplaycloud/image/'.$value->image ) }}" alt="" class="img-fluid styles" id="style_{{ $value->id }}">
                                                <h4>{{ $value->avatar['name'] }}</h4>
                                            </div>
                                        @else   
                                        <div class="point_earn red slider_avtr_blk" id="slider_id_{{$key}}" data-slider="slider_{{ $key }}">
                                                <div class="list_lc loack_avtar"><i></i></div>
                                                <img src="{{ asset('assets/eduplaycloud/image/'.$value->image ) }}" alt="" class="img-fluid">
                                                <h4>{{ $value->avatar['name'] }}</h4>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-3" id="slider-thumbs">
            <div class="mb_rspnv_cls">
                <h4 class="stylish_fnt">Stylise</h4>
                <div class="scrollbar-slidr">
                    <ul class="main_thumbnil hide-bullets">
                        @foreach ($accessories as $key => $value)
                            <li class="col-sm-12">
                                @if ($userTotalPoints >= $value->points)
                                    <a class="galery_thumb_sldr thumbnail" data-avatar_accessories_id=" {{ $value->id }} " id="carousel-selector-{{ $key }}" >
                                    <img src="{{ asset('assets/eduplaycloud/image/'.$value->image) }}" alt="" class="img-fluid" >
                                    </a>
                                @else 
                                <a class="galery_thumb_sldr thumbnail" data-style="thumbnail_{{ $key }}" id="carousel-selector-{{ $key }}">
                                        <div class="loack_avtar"><i></i></div>
                                        <img src="{{ asset('assets/eduplaycloud/image/'.$value->image) }}" alt="" class="img-fluid">
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button type="button" onclick="submitAvatar()" data-status='' id='apply_button' class="btn btn-primary btn-login drk_bg_btn mrgn_ad_20">@lang('filter.apply')</button>
        </div>
    @else 
        <div class="col-sm-8 col-md-9">
            <p>@lang('messages.no_data_available')</p>
        </div>
    @endif
</div>
<script>
    jQuery(document).ready(function($) {

        $('#myCarousel').carousel({
            interval: 5000
        });

        // Check if first item is locked or not
        var lock = $('[id^=carousel-selector-0]').data('style');
        if (lock != undefined) { // Disabled button
            $('#apply_button').data('status','locked');
        } else {
            $('#apply_button').data('status','unlocked');
        }

        // Check if avatar accessories id is defined or not
        var avatar_accessories_id = $('[id^=carousel-selector-0]').data('avatar_accessories_id');
        if (avatar_accessories_id != undefined) {
            $("#avatar_id").val(avatar_accessories_id);
        } else {
            $("#avatar_id").val(0);
        }

        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
            var id_selector = $(this).attr("id");
            try {
                var avatar_accessories_id = $(this).data('avatar_accessories_id');
                if (avatar_accessories_id != undefined) { // Check if avatar accessories id is defined or not
                    $("#avatar_id").val(avatar_accessories_id);
                } else {
                    $("#avatar_id").val(0);
                }
                var locked = $(this).data('style');
                
                if (locked != undefined) { // Disabled button
                    $('#apply_button').data('status','locked');
                } else {
                    $('#apply_button').data('status','unlocked');
                }
                var id = /-(\d+)$/.exec(id_selector)[1];
                
                jQuery('#myCarousel').carousel(parseInt(id));
            } catch (e) {
                console.log('Regex failed!', e);
            }
        });
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
            var id = $('.carousel-item.active').data('slide-number');

            var locked = $("#slider_id_"+id).data('slider');
            if (locked != undefined) { // Disabled button
                $('#apply_button').data('status','locked');
            } else {
                $('#apply_button').data('status','unlocked');
            }

            var avatar_accessories_id = $('#slide_'+id).data('avatar_accessories_id');

            if (avatar_accessories_id != undefined) { // Check if avatar accessories id is defined or not
                $("#avatar_id").val(avatar_accessories_id);
            } else {
                $("#avatar_id").val(0);
            }
            
            $('#carousel-text').html($('#slide-content-'+id).html());
        });
    });
</script>