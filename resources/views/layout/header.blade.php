<header>
    <div class="header js-header js-dropdown">
        <div class="container">
            <div class="header__logo">
                <h1>
                    <img src="{{ asset('bootstrap-forum/fonts/icons/main/Logo_Forum.svg') }}" alt="logo">
                </h1>
                <a href="/" class="text-dark">
                    <div class="header__logo-btn">
                        DevSpace
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
                        <img src="{{ auth()->user()->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/A.svg')  }}" alt="avatar">
                        {{ auth()->user()->getFilamentName() }}<i class="icon-Arrow_Below"></i>
                    </div>
                    <nav class="dropdown dropdown--design-01" data-dropdown-list="user">
                        <div>
                            <div class="dropdown__icons">
                                <a href="#"><i class="icon-Preferences"></i></a>
                                <a href="#"><i class="icon-User"></i></a>
                                <a href="#"><i class="icon-Pencil"></i></a>
                                <a href="{{ route('forum_auth.logout.store') }}"><i class="icon-Logout"></i></a>
                            </div>
                        </div>
                        <div>
                            <ul class="dropdown__catalog">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">Write Thread</a></li>
                                <li><a href="#">Bookmarked</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</header>
