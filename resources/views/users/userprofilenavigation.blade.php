<div class="panel-heading clearfix">
    <div class="container">

        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li>
                    <a href="{{route ('users.user.profile',Auth::user()->id)}}">
                        @lang('user.Profile') </a>
                </li>
                <li>
                    <a href="{{route('pendingtasks.mypendingtasks',Auth::user())}}">
                        @lang('user.Pendingtasks')</a>
                </li>
                <li>
                    <a href="{{route('users.user.childrenlist',Auth::user()->id)}}">
                        @lang('user.Children')</a>

                </li>




            </ul>
        </div>

    </div>
</div>
