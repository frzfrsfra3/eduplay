@if(isset($topic) && count($topic) > 0)
    <div  id="topicssHTML">
        <h5 class="gray-pannel">@lang('exam.select_topic_s1')</h5>
        <div class="row">
            <div class="col-11-rduce col-xl-7">
                <ul class="desipline_list teacher-action">
                    <li>
                    <div class="form-group mrgn-bt-30">
                        <div class="custom-control custom-checkbox">
                            <input  value="1" id="selectallTopic" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="selectallTopic">@lang('exam.select_all')</label>
                        </div>
                    </div>
                    </li>
                    @foreach($topic as $topic)
                        <li>
                            <div class="form-group mrgn-bt-30">
                                <div class="custom-control custom-checkbox">
                                    <input name="selectedId"  value="{{$topic->id}}" id="topic_{{$topic->id}}" type="checkbox" class="custom-control-input selectedTopic"
                                    @if(isset($selected_topic))
                                        @if(in_array($topic->id, $selected_topic)) checked  @endif
                                    @endif
                                    >
                                    <label class="custom-control-label" for="topic_{{$topic->id}}">{{$topic->topic_name}}</label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@else
<div class="row">
    <div class="col-md-12 cusmize-col">
        <input type="hidden" id="notopic" name="" value="0" />
        <p>@lang('exam.no_topic_available')</p>
        </br>
    </div>
</div>
@endif
