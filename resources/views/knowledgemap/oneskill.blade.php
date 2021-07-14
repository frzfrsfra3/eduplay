
<li id="cat{{$skill->id}}" data-paranet="parent{{$skillcategory->id}}" class="list-group-item placeholder li-skill"
    data-id1="c{{$skill->id}}" >
    <i id="i{{$skill->id}}" class="" aria-hidden="true"
       class="icon-move"><b>  {{ $skill->skill_name }} :</b> </i>
         {{$skill->skill_description}}
        <footer>
        <small>
            @if ($skill->get_gradename()<>"")
            <code> {{$skill->get_gradename()}} </code>
            @endif
            @if ($skill->get_topicname()<>"")
            <code class=" btn-info"> {{$skill->get_topicname()}} </code>
            @endif
        </small>


    </footer>

</li>
