<p class="tmr_p">
    @foreach($item->Question_Description->Sections as $qsection)
    @if($qsection->SectionType === 'text')
            <p class="text-new-line">{{$qsection->Value}}</p>
        @else
            @if($qsection->SectionType === "Plugin")
                @if($qsection->Plugin == 'image')
                    <img src="{{$url.'/'.$qsection->Value}}" width="350" height="200">
                @elseif($qsection->Plugin == 'video')
                    <iframe width="350" height="200" src="{{$qsection->Value}}" frameborder="0" allowfullscreen></iframe>
                @elseif($qsection->Plugin == 'audio')
                    <audio width="350" height="60" controls>
                        <source src="{{$url.'/'.$qsection->Value}}">
                    </audio>
                @else
                    <p></p>
                @endif
            @endif
        @endif
    @endforeach    
</p>