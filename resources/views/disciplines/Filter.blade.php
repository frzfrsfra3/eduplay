@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/filter.css') }}">
@endsection
<form method="POST" action="{{ route('disciplines.filter_country_id') }}" accept-charset="UTF-8" id="filter_discipline_form" name="filter_discipline_form" >
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
<div id="filtertitle">
    <div class="filterhead" >
        Filters
    </div>
    <div class="lines">
        <select class="dropdownlist" name="Language_id">
            <option value=""  >Select Language</option>
            @foreach($languages as $language)
                <option value="{{$language->id}}">{{$language->language}}</option>
            @endforeach
        </select>


    </div>
    <div class="lines">
        <select class="dropdownlist" name="country_id"  id="country_id">
            <option value=""  >Select Country</option>
            @foreach($country_list as $country)
                <option value="{{$country->id}}">{{$country->country_name}}</option>
            @endforeach
        </select>
    </div>



    <div class="lines">
        <select class="dropdownlist" name="curriculum_gradelist_id">
            <option value=""  >Select Curriculum</option>
            @foreach($curricula as $curriculum)
                <option value="{{$curriculum->id}}">{{$curriculum->curriculum_gradelist_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="buttondiv">



    </div>




        <div class="lines" >

            <input class="button" type="submit" value="Apply">
            </div>

</div>
    </form>


