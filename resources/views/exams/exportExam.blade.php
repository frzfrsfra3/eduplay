		@php
		$sum=0;
		foreach($questions as $key => $question){
			$sum+=$question->maxtime;
		}
		@endphp
		<tr>
			<td>
				<input type="hidden" id="totalQuestion" name="totalQuestion" value="{{count($questions)}}" />
				<input type="hidden" id="totalduration" name="totalduration" value="{{ gmdate("H:i:s", $sum) }}" />
				<input type="hidden" id="totalMarksHidden" name="totalMarksHidden" value="" />
				<input type="hidden" id="htmlSrcData" name="htmlSrcData" value="" />
				<div id="jsonDivExamDetails" data-json="{{ $finalJsonObjSelQue}}">
				</div>
			</td>
		</tr>
		<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<tbody>
				<tr>
					<td id="previewExamExport">
					</td>
				</tr>
				</tbody>
			</table>
		</td></tr>


		<script id="sample_template_ExamDetails" type="text/html">
			@{{#.}}
				<table width="100%" border="0" cellspacing="0" cellpadding="10" >
					<tbody>
					
					@{{#Questions}}
					<tr>
						<td  width="80%" style="font-weight: 500;color: #4c4c4c;font-size: 14px;vertical-align: top;" valign="top">
							<input type="hidden" name="mark[@{{question_id}}]" class="form-control markClass" data-mark="@{{question_id}}" id="@{{question_id}}" value="@{{ mark }}" min="0">
							
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="2%" valign="top" style="font-size: 14px;padding-bottom:7px;font-weight: 600;vertical-align: top;padding-right:7px;padding-top:2px;">
										Q@{{& question_count}}:
									</td>
									<td width="98%" valign="top"> 
									@{{#Question_Description.Sections}}
										<table width="100%" border="0" cellspacing="0" cellpadding="0" >
											<tr>
												<td style="font-size: 14px;padding-bottom:7px;font-weight: 600;vertical-align: top;">
													@{{& Value}}
												</td>
											</tr>
										</table>
									@{{/Question_Description.Sections}}
									</td>
								</tr>
								@{{#Answers.Choices}}
								<tr>
									<td width="2%" style="padding-right:12px;vertical-align: top;padding-top:3px;">
										<span style="vertical-align: middle;">
											@{{& string}}
										</span>
									</td>
									<td width="98%" style="vertical-align: top;">
										@{{#Sections}}
										<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px;">
											<tr>
												<td>
													@{{& Value}}
												</td>
											</tr>
										</table>
										@{{/Sections}}
									</td>
								</tr>
								@{{/Answers.Choices}}
							</table>
						</td>
						<td width="20%" valign="top" style="font-weight: 700;color: #ff9028;font-size: 14px;vertical-align: top;">
							Points: @{{ mark }}
						</td>
					</tr>
						@{{/Questions}}
						
					</tbody>
				</table>
				@{{/.}}
		</script>