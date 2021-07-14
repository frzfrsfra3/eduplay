
@foreach($item->Hints->HintList as $hintkey => $hint)
    @foreach ($hint->Sections as $hintsectionskey  => $hintsection)
        <p class="hint_p">
            Not Sure About The Answer? Get <a href="#" data-toggle="collapse" data-target="#collapseHint-{{$hintsectionskey}}" aria-expanded="false" aria-controls="collapseHint-{{$hintsectionskey}}">HINT</a>
        </p>    
    {{-- {{print_r()}} --}}
        <div class="collapse hint_clps" id="collapseHint-{{$hintsectionskey}}">
            <div class="card card-body">
                <div class="hint-card">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="rltv_hint">
                                <h5>Hint</h5>
                                <p>
                                    @if($hintsection->SectionType === 'text')
                                        {{$hintsection->Value}}
                                    @else
                                        @if($hintsection->SectionType === "Plugin")
                                            @if($hintsection->Plugin == 'image')
                                                <img src="{{$url.'/'.$hintsection->Value}}" width="350" height="200">
                                            @elseif($hintsection->Plugin == 'video')
                                                <iframe width="350" height="200" src="{{$hintsection->Value}}" frameborder="0" allowfullscreen></iframe>
                                            @elseif($hintsection->Plugin == 'audio')
                                                <audio width="350" height="60" controls>
                                                    <source src="{{$url.'/'.$hintsection->Value}}">
                                                </audio>
                                            @else
                                                <p></p>
                                            @endif
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                        {{-- <div class="col-md-8"><img src="image/hint_img.png" align="" class="img-fluid"></div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach