<div class="d-flex gap-3 align-items-center justify-content-center my-5">
    <a class="btn btn-outline-warning text-warning {{ request()->routeIs('forum.my_thread.*') ? 'btn-warning-active' : '' }}" href="{{ route('forum.my_thread.index') }}">My Thread</a>
    <a class="btn btn-outline-warning text-warning {{ request()->routeIs('forum.profile.*') ? 'btn-warning-active' : '' }}" href="{{ route('forum.profile.index') }}">
        Profile
    </a>
    <a class="btn btn-outline-warning text-warning {{ request()->routeIs('forum.setting.*') ? 'btn-warning-active' : '' }}" href="{{ route('forum.setting.index') }}">Setting</a>
</div>

<hr style="margin-top: -10px">
