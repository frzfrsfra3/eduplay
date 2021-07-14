@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn text-ar-right mrgn-bt-40">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<nav aria-label="tp-breadcm" class="tp-breadcm">
					<ol class="breadcrumb">
						@php
							$url=str_replace(url('/'), '', url()->previous());
							$url2=substr($url, 0, strrpos($url, "/"));
							$funalURL=substr($url2, 0, strrpos($url2, "/"));
							// /reports/skill/performance

							$curl=str_replace(url('/'), '', url()->previous());
							$curl2=substr($curl, 0, strrpos($curl, "/"));
							$curl3=substr($curl2, 0, strrpos($curl2, "/"));
							$finalCurl=substr($curl3, 0, strrpos($curl3, "/"));
							// /reports/skill

							if($funalURL == '/reports/skill/performance/view/by/test' || $finalCurl == '/reports/exercise/set/report/exam'){
								$pageUrl=Request::getPathInfo();
								$pageUrlSkip1=substr($pageUrl, 0, strrpos($pageUrl, "/"));
								$pageUrlSkip2=substr($pageUrlSkip1, 0, strrpos($pageUrlSkip1, "/"));
								$finalUrls=substr($pageUrlSkip2, 0, strrpos($pageUrlSkip2, "/"));
								// For Id ( Class, User )
								$breakUrl=explode('/',$pageUrl);
								$id= array_slice($breakUrl, -2, 2, true);
								$idUrl= implode('/',$id);
								/* $urlclass=url()->current();
								$breakUrl=explode('/',$urlclass);
								$idUrl=$breakUrl[11].'/'.$breakUrl[12];
								$finalUrls=$breakUrl[5].'/'.$breakUrl[6].'/'.$breakUrl[7].'/'.$breakUrl[8].'/'.$breakUrl[9];*/
							}
							else{
								// ( reports/exercise/set/report )
								$pageUrl=Request::getPathInfo();
								$pageUrlSkip1=substr($pageUrl, 0, strrpos($pageUrl, "/"));
								$pageUrlSkip2=substr($pageUrlSkip1, 0, strrpos($pageUrlSkip1, "/"));
								$finalUrls=substr($pageUrlSkip2, 0, strrpos($pageUrlSkip2, "/"));
								// For Id ( Class, User )
								$breakUrl=explode('/',$pageUrl);
								$id= array_slice($breakUrl, -2, 2, true);
								$idUrl= implode('/',$id);
								/* $urlclass=url()->current();
								$breakUrl=explode('/',$urlclass);
								echo $idUrl=$breakUrl[10].'/'.$breakUrl[11]."<br>";
								echo $finalUrls=$breakUrl[5].'/'.$breakUrl[6].'/'.$breakUrl[7].'/'.$breakUrl[8];die; */
							}
						@endphp
                        <li class="breadcrumb-item"><a href="{{ route('reports')}}"> @lang('reports.reports')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports')}}"> @lang('reports.learner_discipline_rerformance_report')</a></li>
						{{--  <li class="breadcrumb-item active" aria-current="page" ><a href="">Skill Category Performance Report</li>  --}}
						@php $classIdArr = []; @endphp
						@if ($funalURL == '/reports/skill/performance/view/by/test' || $finalCurl == '/reports/exercise/set/report/exam')
							@php
								/*$urldata1=Request::segment(6);
								$urldata2=Request::segment(7);
								echo $urldata1.' \ '.$urldata2;exit;*/
								//$urldata3=Request::segment(8);
								$pageUrl=Request::getPathInfo();
								$breakUrl=explode('/',$pageUrl);
								$id= array_slice($breakUrl, -3, 2, true);
								$ClassId = reset($id);
								$UserId = end($id);
								array_push($classIdArr, $ClassId);
							@endphp
							<li class="breadcrumb-item"><a href="{{ route('skillPerformanceViewbyTest',[$ClassId,$UserId])}}">@lang('reports.skills_performance_report')</a></li>
						@else
							@php
                                /* $urldata1=Request::segment(5);
								$urldata2=Request::segment(6);
								echo $urldata1.' \ '.$urldata2;exit;*/
								$pageUrl=Request::getPathInfo();
								$breakUrl=explode('/',$pageUrl);
								$id= array_slice($breakUrl, -3, 2, true);
								$ClassId = reset($id);
								$UserId = end($id);
								array_push($classIdArr, $ClassId);
							@endphp
							<li class="breadcrumb-item"><a href="{{ route('skillPerformance',[$ClassId,$UserId])}}">@lang('reports.skills_performance_report')</a></li>
						@endif

						<li class="breadcrumb-item active" aria-current="page">@lang('reports.exercise_set_report')</li>
					</ol>
				</nav>
				<div class="title_with_shrtby">
					<h4 class=" float-sm-left reprt-title">@lang('reports.exercise_set_report')</h4>
					<div class="float-sm-right short_by text-right">
						<div class="short_by_select">
							<label>@lang('reports.sort_by'):</label>
							<select class="selectpicker" id="crtOrNot">
								<option value="correct">@lang('reports.correct')</option>
								<option value="wrong">@lang('reports.wrong')</option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
				<div class="mdl_space text-ar-right">
					<h4 class="mrgn-bt-10">{{ $userId->name }}</h4>
					<div class="float-left col-md-12">
						@if ($funalURL == '/reports/skill/performance/view/by/test' || $finalCurl == '/reports/exercise/set/report/exam')
							@if(isset($questions->exam->title))
								<p>{{$questions->exam->title}}
							@endif
						@else
							@if(count($questions) > 0)
								<p>{{$questions[0]->skill->skill_name}}</p>
							@else
								<div class="inner_pannel panel panel-default">
									<center>@lang('reports.no_data') !!!</center>
								</div>
							@endif
						@endif
					</div>
					<div class="float-right">
						{{--  <div class="df-select">
							{{--  {{ $_COOKIE['reportRole'] }}  --}
							@if(isset($_COOKIE['reportRole']))
								<select class="selectpicker" id="classFilter">
									@if($_COOKIE['reportRole'] == 'Teacher')
										@foreach($classList as $key=>$class)
											<option value="{{ $class->id }}" @php echo ($classIdArr[0] == $class->id) ? 'selected="selected"' : ''; @endphp>{{ $class->class_name }}</option>
										@endforeach
									@elseif($_COOKIE['reportRole'] == 'Learner')
										@foreach($classListLearnervise as $key=>$class)
											<option value="{{ $class->class_id }}" @php echo ($classIdArr[0] == $class->class_id) ? 'selected="selected"' : ''; @endphp>{{ $class->courseclass->class_name }}</option>
										@endforeach
									@else
										@foreach($classList as $key=>$class)
											<option value="{{ $class->id }}" @php echo ($classIdArr[0] == $class->id) ? 'selected="selected"' : ''; @endphp>{{ $class->class_name }}</option>
										@endforeach
									@endif
								</select>
							@else
								<select class="selectpicker" id="classFilter">
									@foreach($classList as $key=>$class)
										<option value="{{ $class->id }}">{{ $class->class_name }}</option>
									@endforeach
								</select>
							@endif
							{{--  {{ $_COOKIE['reportRole'] }}  --}
						</div>  --}}
					</div>
					<div class="clearfix"></div>
				</div>
				@if ($funalURL == '/reports/skill/performance/view/by/test' || $finalCurl == '/reports/exercise/set/report/exam')
					<div class="exercise_reprt center-block">
						<div class="pannel_exercise panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							@php
								$isCorrect = '';
							@endphp
							@if (isset($questions->getExamquestion) && !empty($questions->getExamquestion))
								@foreach ($questions->getExamquestion as $key=>$quedata)
									<div class="inner_pannel panel panel-default">
										<div class="panel-heading active" role="tab" id="headingOne">
											<div class="panel-title">
												<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne{{$key}}">
													<p>{{ $quedata->question->details }}</p>
												</a>
											</div>
										</div>
										<div id="collapseOne{{$key}}" class="panel-collapse collapse @if ($loop->first) show @endif" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">
												<ul class="ans_list">
													@if (isset($quedata->answereoption) && !empty($quedata->answereoption))
														@foreach ($quedata->answereoption as $akey => $anslist)
														@php
															$questionId=$quedata->question->id;
															$answerId=$anslist->id;
															$uId=$userId->id;
															$userData=QueryHelper::UserNameExamAnswer($questionId,$answerId,$uId);
														if ($anslist->iscorrect == '1' && $userData['answer_id']  == $answerId):
															$isCorrect = '1';
														else:
															$isCorrect = '0';
														endif;
														@endphp
															<li
																@if($userData['answer_id']  == $answerId) class="slected" @endif
																@if($anslist->iscorrect == '1' && $userData['answer_id']  == $answerId)
																	id="correct"
																@else
																	id="wrong"
																@endif
															>
																@if($anslist->iscorrect == '1')
																	<i class="grn_bx"></i>
																	<span class="grn_tx">
																		@php
																			$questionId=$quedata->question_id;
																			$answerId=$anslist->id;
																			//dd($questionId,$answerId,collect(request()->segments())->last());
																			$anspercentage	=QueryHelper::getAnswerPercentage($questionId,$answerId,collect(request()->segments())->last());
																			$per= round(($anspercentage * 100) / $learnerCount);
																		@endphp
																		{{ $per }}%
																	</span>
																	<span class="grn_tx">
																		{{ $anslist->details }}
																	</span>
																@else
																	<i class="rd_bx" ></i>
																	<span class="rd_tx">
																		@php
																			$questionId=$quedata->question_id;
																			$answerId=$anslist->id;
																			$anspercentage	=QueryHelper::getAnswerPercentage($questionId,$answerId,collect(request()->segments())->last());
																			$per= round(($anspercentage * 100) / $learnerCount);
																		@endphp
																		{{ $per }}%
																	</span>
																	<span class="optn_tx">
																		{{ $anslist->details }}
																	</span>
																@endif

																@if($userData['answer_id']  == $answerId)
																	<span class="orng_tx">{{ $userData->User->name }}</span>
																@endif
															</li>
														@endforeach
													@else
														<p>@lang('reports.no_data') !!!</p>
													@endif
												</ul>
											</div>
										</div>
									</div>
								@endforeach
							@else
								<div class="inner_pannel panel panel-default">
									<center>@lang('reports.no_data') !!!</center>
								</div>
							@endif
						</div>
					</div>
				@else
					<div class="exercise_reprt center-block">
						<div class="pannel_exercise panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							@php
								$isCorrect = '';
							@endphp
							@if (isset($questions) && !empty($questions))
								@foreach ($questions as $key=>$quedata)
									<div class="inner_pannel panel panel-default">
										<div class="panel-heading active" role="tab" id="headingOne">
											<div class="panel-title">
												<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne{{$key}}">
													<p>{{ $quedata->details }}</p>
												</a>
											</div>
										</div>
										<div id="collapseOne{{$key}}" class="panel-collapse collapse @if ($loop->first) show @endif" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">
												<ul class="ans_list">
													@if (isset($quedata->answeroptions) && !empty($quedata->answeroptions))
														@foreach ($quedata->answeroptions as $akey => $anslist)
															@php
																$questionId=$quedata->id;
																$answerId=$anslist->id;
																$uId=$userId->id;
																$userData=QueryHelper::UserNameExamAnswer($questionId,$answerId,$uId);
																if ($anslist->iscorrect == '1' && $userData['answer_id']  == $answerId):
																	$isCorrect = '1';
																else:
																	$isCorrect = '0';
																endif;
															@endphp
															<li
																@if($userData['answer_id']  == $answerId) class="slected" @endif
																@if($anslist->iscorrect == '1' && $userData['answer_id']  == $answerId)
																	id="correct"
																@else
																	id="wrong"
																@endif
															>
																@if($anslist->iscorrect == '1')
																	<i class="grn_bx"></i>
																	<span class="grn_tx">
																		@php
																			$questionId=$quedata->id;
																			$answerId=$anslist->id;
																			$anspercentage	=QueryHelper::getAnswerPercentage($questionId,$answerId);
																			$per= round(($anspercentage * 100) / $learnerCount);
																		@endphp
																		{{ $per }}%
																	</span>
																	<span class="grn_tx">{{ $anslist->details }} </span>
																@else
																	<i class="rd_bx"></i>
																	<span class="rd_tx">
																		@php
																			$questionId=$quedata->id;
																			$answerId=$anslist->id;
																			$anspercentage	=QueryHelper::getAnswerPercentage($questionId,$answerId);
																			$per= round(($anspercentage * 100) / $learnerCount);
																		@endphp
																		{{ $per }}%
																	</span>
																	<span class="optn_tx"> {{ $anslist->details }} </span>
																@endif
																@if($userData['answer_id']  == $answerId)
																	<span class="orng_tx">{{ $userData->User->name }}</span>
																@endif
															</li>
														@endforeach
													@else
														<p>@lang('reports.no_data') !!!</p>
													@endif
												</ul>
											</div>
										</div>
									</div>
								@endforeach
							@else
								<p>@lang('reports.no_data') !!!</p>
							@endif
						</div>
					</div>
				@endif
				<p align="center" id="noDataAvailable" style="display: none;">@lang('reports.no_data') !!!</p>
			</div>
		</div>
	</div>
</div>


@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
		$(document).ready(function(){
			$('#classFilter').on('change', function (e) {
				var classId = $('#classFilter').val();
				var idUrl = '<?php echo $idUrl; ?>';
				var finalUrls = '<?php echo $finalUrls; ?>';
				//alert(site_url+finalUrls+'/'+classId+'/'+idUrl);
				window.location.href =site_url+finalUrls+'/'+classId+'/'+idUrl;
			});
		});

		$('#crtOrNot').change(function () {
			var selectedItem = $(this).find("option:selected").val();

			if (selectedItem == 'wrong') {
				$(".ans_list #wrong").parents('.inner_pannel').show();
				$(".ans_list #correct").parents('.inner_pannel').hide();
			} else {
				$(".ans_list").parents('.inner_pannel').hide();
				$(".ans_list #correct").parents('.inner_pannel').show();
			}

			if($(".inner_pannel").is(":visible")){
				$('#noDataAvailable').hide();
			} else{
				$('#noDataAvailable').show();
			}
		});
</script>
@endpush