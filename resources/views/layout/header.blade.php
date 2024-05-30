<header>
    <div class="header js-header js-dropdown">
        <div class="container">
            <div class="header__logo">
                <h1>
                    <img src="{{ asset('bootstrap-forum/fonts/icons/main/Logo_Forum.svg') }}" alt="logo">
                </h1>
                <a href="/" class="text-dark">
                    <div class="header__logo-btn">
                        DevSpaces
                    </div>
                </a>
            </div>
            <div class="header__search">
                <form action="#">
                    <label>
                        <i class="icon-Search js-header-search-btn-open"></i>
                        <input type="search" placeholder="Search all forums" class="form-control">
                    </label>
                </form>
            </div>
            @if(!Auth::check())
                <div>
                    <a href="{{ route('forum_auth.register.index') }}" class="btn btn--type-02">Join The DevSpaces Community</a>
                </div>
            @else
                <div class="header__user">
                    <div class="header__user-btn" data-dropdown-btn="user">
                        <img src="{{ auth()->user()->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/A.svg')  }}" alt="avatar" class="rounded-circle">
                        {{ auth()->user()->getFilamentName() }}<i class="icon-Arrow_Below"></i>
                    </div>
                    <nav class="dropdown dropdown--design-01" data-dropdown-list="user">
                        <div>
                            <ul class="dropdown__catalog">
                                <li>
                                    <a href="{{ route('forum.my_thread.index') }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa fa-quote-left"></i>
                                            My Thread
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('forum.profile.index') }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa fa-user"></i>
                                            My Profile
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa fa-pencil"></i>
                                            Write Thread
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('forum_auth.logout.store') }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa fa-sign-out"></i>
                                            Sign Out
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</header>
