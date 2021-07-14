<div class="mrgn_btm_100">
    <h6 class="basic_title">My Interests</h6>
</div>

    <form class="def_form" method="post" action="{{ route('users.user.profile.update-interests' , $user->id) }}">
       @csrf
        <div class="form-group">
            <ul class="prsn-action">
                @if(isset($topics))
                @foreach($topics as $topic)
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array($topic->id, $userTopics)) checked @endif name="bit_topics[]" id="bit_topics[{{ $topic->id }}]" class="custom-control-input yourTopics" value="{{ $topic->id }}"/>
                            @if (strlen($topic->iconurl)==0)
                                <img src={{ asset('assets/images/topic_default-test.png') }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                            @else
                                @php
                                    $file = public_path("assets/images/").$topic->iconurl;
                                    $fileExists = file_exists($file);
                                @endphp

                                @if (isset($fileExists) && !empty($fileExists))
                                    <img src={{ asset('assets/images/'.$topic->iconurl) }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                                @else
                                    <img src={{ asset('assets/images/topic_default-test.png') }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                                @endif
                            @endif
                            <label class="custom-control-label">{{ $topic->topic_name }}</label>
                        </div>
                    </li>
                @endforeach
                @endif
            </ul>
            <span class="error-message error-topic"></span>
        </div>
        <div class="form-group mrgnt back_top_mrgn">
            <button type="submit" class="btn btn-primary btn-login">Save</button>
        </div>
    </form>
