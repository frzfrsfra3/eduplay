
<div class="form-group {{ $errors->has('platform_id') ? 'has-error' : '' }}">
    <label for="platform_id" class="col-md-2 control-label">Platform</label>
    <div class="col-md-10">
        <select class="form-control" id="platform_id" name="platform_id" required="true">
        	    <option value="" style="display: none;" {{ old('platform_id', optional($gamedetail)->platform_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select platform</option>
        	@foreach ($platforms as $key => $platform)
			    <option value="{{ $key }}" {{ old('platform_id', optional($gamedetail)->platform_id) == $key ? 'selected' : '' }}>
			    	{{ $platform }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('platform_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('game_id') ? 'has-error' : '' }}">
    <label for="game_id" class="col-md-2 control-label">Game</label>
    <div class="col-md-10">
        <select class="form-control" id="game_id" name="game_id" required="true">
        	    <option value="" style="display: none;" {{ old('game_id', optional($gamedetail)->game_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select game</option>
        	@foreach ($games as $key => $game)
			    <option value="{{ $key }}" {{ old('game_id', optional($gamedetail)->game_id) == $key ? 'selected' : '' }}>
			    	{{ $game }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('game_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('android_link') ? 'has-error' : '' }}">
    <label for="android_link" class="col-md-2 control-label">Android Link</label>
    <div class="col-md-10">
        <input class="form-control" name="android_link" type="text" id="android_link" value="{{ old('android_link', optional($gamedetail)->android_link) }}" maxlength="500" placeholder="Enter android link here...">
        {!! $errors->first('android_link', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ios_link') ? 'has-error' : '' }}">
    <label for="ios_link" class="col-md-2 control-label">Ios Link</label>
    <div class="col-md-10">
        <input class="form-control" name="ios_link" type="text" id="ios_link" value="{{ old('ios_link', optional($gamedetail)->ios_link) }}" maxlength="500" placeholder="Enter ios link here...">
        {!! $errors->first('ios_link', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ios_bundle_id') ? 'has-error' : '' }}">
    <label for="ios_bundle_id" class="col-md-2 control-label">Ios Bundle</label>
    <div class="col-md-10">
        <select class="form-control" id="ios_bundle_id" name="ios_bundle_id">
        	    <option value="" style="display: none;" {{ old('ios_bundle_id', optional($gamedetail)->ios_bundle_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select ios bundle</option>
        	@foreach ($iosBundles as $key => $iosBundle)
			    <option value="{{ $key }}" {{ old('ios_bundle_id', optional($gamedetail)->ios_bundle_id) == $key ? 'selected' : '' }}>
			    	{{ $iosBundle }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('ios_bundle_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ios_url_scheme_suffix') ? 'has-error' : '' }}">
    <label for="ios_url_scheme_suffix" class="col-md-2 control-label">Ios Url Scheme Suffix</label>
    <div class="col-md-10">
        <input class="form-control" name="ios_url_scheme_suffix" type="text" id="ios_url_scheme_suffix" value="{{ old('ios_url_scheme_suffix', optional($gamedetail)->ios_url_scheme_suffix) }}" maxlength="500" placeholder="Enter ios url scheme suffix here...">
        {!! $errors->first('ios_url_scheme_suffix', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ios_iphone_store_id') ? 'has-error' : '' }}">
    <label for="ios_iphone_store_id" class="col-md-2 control-label">Ios Iphone Store</label>
    <div class="col-md-10">
        <select class="form-control" id="ios_iphone_store_id" name="ios_iphone_store_id">
        	    <option value="" style="display: none;" {{ old('ios_iphone_store_id', optional($gamedetail)->ios_iphone_store_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select ios iphone store</option>
        	@foreach ($iosIphoneStores as $key => $iosIphoneStore)
			    <option value="{{ $key }}" {{ old('ios_iphone_store_id', optional($gamedetail)->ios_iphone_store_id) == $key ? 'selected' : '' }}>
			    	{{ $iosIphoneStore }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('ios_iphone_store_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ios_ipad_store_id') ? 'has-error' : '' }}">
    <label for="ios_ipad_store_id" class="col-md-2 control-label">Ios Ipad Store</label>
    <div class="col-md-10">
        <select class="form-control" id="ios_ipad_store_id" name="ios_ipad_store_id">
        	    <option value="" style="display: none;" {{ old('ios_ipad_store_id', optional($gamedetail)->ios_ipad_store_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select ios ipad store</option>
        	@foreach ($iosIpadStores as $key => $iosIpadStore)
			    <option value="{{ $key }}" {{ old('ios_ipad_store_id', optional($gamedetail)->ios_ipad_store_id) == $key ? 'selected' : '' }}>
			    	{{ $iosIpadStore }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('ios_ipad_store_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('android_package_name') ? 'has-error' : '' }}">
    <label for="android_package_name" class="col-md-2 control-label">Android Package Name</label>
    <div class="col-md-10">
        <input class="form-control" name="android_package_name" type="text" id="android_package_name" value="{{ old('android_package_name', optional($gamedetail)->android_package_name) }}" min="0" max="500" placeholder="Enter android package name here...">
        {!! $errors->first('android_package_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('android_key_hashes') ? 'has-error' : '' }}">
    <label for="android_key_hashes" class="col-md-2 control-label">Android Key Hashes</label>
    <div class="col-md-10">
        <input class="form-control" name="android_key_hashes" type="text" id="android_key_hashes" value="{{ old('android_key_hashes', optional($gamedetail)->android_key_hashes) }}" maxlength="500" placeholder="Enter android key hashes here...">
        {!! $errors->first('android_key_hashes', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('android_class_name') ? 'has-error' : '' }}">
    <label for="android_class_name" class="col-md-2 control-label">Android Class Name</label>
    <div class="col-md-10">
        <input class="form-control" name="android_class_name" type="text" id="android_class_name" value="{{ old('android_class_name', optional($gamedetail)->android_class_name) }}" maxlength="500" placeholder="Enter android class name here...">
        {!! $errors->first('android_class_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('android_amazon_url') ? 'has-error' : '' }}">
    <label for="android_amazon_url" class="col-md-2 control-label">Android Amazon Url</label>
    <div class="col-md-10">
        <input class="form-control" name="android_amazon_url" type="text" id="android_amazon_url" value="{{ old('android_amazon_url', optional($gamedetail)->android_amazon_url) }}" maxlength="500" placeholder="Enter android amazon url here...">
        {!! $errors->first('android_amazon_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

