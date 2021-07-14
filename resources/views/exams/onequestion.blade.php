<div  id="question{{$question->id}}" name="question{{$question->id}}"  class="isquestion">
	<label class="container-checkbox check-block">
		<div  class="quest-display" style="display: inline-block" id="q-{!!$question->id !!}">
			{!! $question->details !!}
		</div>
		<input type="checkbox" class="ischecked question_checked"
		data-duration="{{$question->maxtime}}"  data-id="{{$question->id}}" name="selected_question[{{$question->id}}]" id="selected_question{{$question->id}}"
		@if ($ischecked==1)
		checked
		@endif
		>
		<span class="checkmark"></span>
		@if ( is_null( $question->skill_id) <>true)
		<footer > <span style="background-color: rgba(218,218,218,0.52)"> {!! $question->skill->skill_name !!} </span></footer>
		@endif
	</label>
</div>