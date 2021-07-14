@section('header_styles')
<style>
</style>
@endsection

<!-- Start Field -->
@php 
    $currentFieldName = 'name';
    $currentFieldNameToView = ucwords(str_replace('_', ' ', $currentFieldName)); // make field name readable
@endphp
<div class="form-group {{ $errors->has($currentFieldName) ? 'has-error' : '' }}">
    <label for="{{ $currentFieldName }}" class="col-md-2 control-label">{{ $currentFieldNameToView }}</label>
    <div class="col-md-10">
        <input class="form-control" name="{{ $currentFieldName }}" type="text" id="{{ $currentFieldName }}" value="{{ old($currentFieldName, optional($plan)[$currentFieldName]) }}">
        {!! $errors->first($currentFieldName, '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!-- End Field -->

<!-- Start Field -->
@php 
    $currentFieldName = 'description';
    $currentFieldNameToView = ucwords(str_replace('_', ' ', $currentFieldName)); // make field name readable
@endphp
<div class="form-group {{ $errors->has($currentFieldName) ? 'has-error' : '' }}">
    <label for="{{ $currentFieldName }}" class="col-md-2 control-label">{{ $currentFieldNameToView }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="{{ $currentFieldName }}" id="{{ $currentFieldName }}">{{ old($currentFieldName, optional($plan)[$currentFieldName]) }}</textarea>
        {!! $errors->first($currentFieldName, '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!-- End Field -->

<!-- Start Field -->
@php 
    $currentFieldName = 'price';
    $currentFieldNameToView = ucwords(str_replace('_', ' ', $currentFieldName)); // make field name readable
@endphp
<div class="form-group {{ $errors->has($currentFieldName) ? 'has-error' : '' }}">
    <label for="{{ $currentFieldName }}" class="col-md-2 control-label">{{ $currentFieldNameToView }}</label>
    <div class="col-md-10">
        <input class="form-control" name="{{ $currentFieldName }}" type="number" id="{{ $currentFieldName }}" value="{{ old($currentFieldName, optional($plan)[$currentFieldName]) }}">
        {!! $errors->first($currentFieldName, '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!-- End Field -->

<!-- Start Field -->
@php 
    $currentFieldName = 'visibility';
    $currentFieldNameToView = ucwords(str_replace('_', ' ', $currentFieldName)); // make field name readable
@endphp
<div class="form-group {{ $errors->has($currentFieldName) ? 'has-error' : '' }}">
    <label for="{{ $currentFieldName }}" class="col-md-2 control-label">{{ $currentFieldNameToView }}</label>
    <div class="col-md-10">
        <select class="form-control" name="{{ $currentFieldName }}" id="{{ $currentFieldName }}" >
            <option value="public" @if ( old($currentFieldName, optional($plan)[$currentFieldName]) == "public") selected @endif>Public</option>
            <option value="private" @if ( old($currentFieldName, optional($plan)[$currentFieldName]) == "private") selected @endif>Private</option>
        </select>
        {!! $errors->first($currentFieldName, '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!-- End Field -->

<!-- Start Field -->
@php 
    $currentFieldName = 'role_id';
    $currentFieldNameToView = "Role";
@endphp
<div class="form-group {{ $errors->has($currentFieldName) ? 'has-error' : '' }}">
    <label for="{{ $currentFieldName }}" class="col-md-2 control-label">{{ $currentFieldNameToView }}</label>
    <div class="col-md-10">
        <select class="form-control" name="{{ $currentFieldName }}" id="{{ $currentFieldName }}" >
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @if ( old($currentFieldName, optional($plan)[$currentFieldName]) == $role->id) selected @endif>{{ $role->name }}</option>
            @endforeach
        </select>
        {!! $errors->first($currentFieldName, '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!-- End Field -->
@section('footer_scripts')
<script>

</script>
@endsection