<div class="box-list">
	<div class="select-all-box">@lang('exam.skill_categories') :
		{{$skillcategories->count()}}<br>
		<label class="container-checkbox check-block">@lang('exam.all_skill_categories')
		<input type="checkbox"  class="ischecked  allskillcat"  name="allskillcategories" id="allskillcategories" >
		<span class="checkmark"></span>
		</label>
	</div>
	<div class="col-12  scroll-list scroll-style" >
		@foreach( $skillcategories as $skillcategory )
            <label class="container-checkbox check-block">{{$skillcategory->skill_category_name}}
            <input type="checkbox"  class="ischecked skillcat"  name="skillcategory[{{$skillcategory->id}}]" id="skillcategory{{$skillcategory->id}}" >
            <span class="checkmark"></span>
            </label>
		@endforeach
		<div class="force-overflow"></div>
	</div>
</div>
