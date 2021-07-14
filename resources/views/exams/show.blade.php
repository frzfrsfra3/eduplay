<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <h3 class="exam_title">@lang('exam.exam_details')</h3>
    @if(isset($exam))
        <div class="row">
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                        <div class="row">
                            <div class="col-6">
                                <p>@lang('exam.exam_type')</p>
                            </div>
                            <div class="col-6">
                                <h6>{{ $exam->examtype }}</h6>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-6">
                            <p>@lang('exam.title')</p>
                        </div>
                        <div class="col-6">
                            <h6>{{ $exam->title }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-6">
                            <p>@lang('exam.created')</p>
                        </div>
                        <div class="col-6">
                            <h6>{{ $exam->created_at }}</h6>
                            {{--  <h6>10/07/2018 At 11:48 AM</h6>  --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-6">
                            <p>@lang('exam.updated')</p>
                        </div>
                        <div class="col-6">
                            <h6>{{ $exam->updated_at }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-3">
                            <p>@lang('exam.skill_category')</p>
                        </div>
                        <div class="col-9">
                            <h6>
                                @if(!empty($skillcategorys))
                                    {{ $skillcategorys }}
                                @else 
                                    @lang('messages.no_data_found')
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-3">
                            <p>@lang('exam.skills')</p>
                        </div>
                        <div class="col-9">
                            <h6>
                                @if(!empty($skills))
                                    {{ $skills }}
                                @else 
                                    @lang('messages.no_data_found')
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-6">
                            <p>@lang('exam.availability')</p>
                        </div>
                        <div class="col-6">
                            <h6>{{ $exam->isavailable =='N' ? 'No' : 'Yes' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="exam_detail right_contnt text-ar-right">
                    <div class="row">
                        <div class="col-6">
                            <p>@lang('exam.teacher')</p>
                        </div>
                        <div class="col-6">
                            <h6>{{ $exam->teacheruser->name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>