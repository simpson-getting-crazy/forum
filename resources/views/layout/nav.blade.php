@props(['categories' => \App\Models\Category::orderBy('name', 'asc')->get()])

<div class="nav">
    <div class="nav__categories js-dropdown">
        <div class="nav__select">
            <div class="btn-select" data-dropdown-btn="categories">All Categories</div>
            <nav class="dropdown dropdown--design-01" data-dropdown-list="categories">
                <ul class="dropdown__catalog row">
                    @foreach($categories as $category)
                        <li class="col-xs-6">
                            <a href="{{ route('forum.index', ['category' => $category->slug, 'tabFilter' => request()->get('tabFilter') ?? '0']) }}" class="category">
                                <i style="background-color: {{ $category->color }}"></i>
                                {{ Str::limit($category->name, 12) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
    <div class="nav__menu js-dropdown">
        <div class="nav__select">
            <div class="btn-select" data-dropdown-btn="menu">Latest</div>
            <div class="dropdown dropdown--design-01" data-dropdown-list="menu">
                <ul class="dropdown__catalog">
                    <li class="{{ request()->get('tabFilter') == 'latest' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'latest']) }}">Latest</a></li>
                    <li class="{{ request()->get('tabFilter') == 'mostViewed' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'mostViewed']) }}">Most Viewed</a></li>
                    <li class="{{ request()->get('tabFilter') == 'mostActive' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'mostActive']) }}">Most Active Threads</a></li>
                    <li><a href="/">Reset Filter</a></li>
                </ul>
            </div>
        </div>
        <ul>
            <li class="{{ request()->get('tabFilter') == 'latest' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'latest']) }}">Latest</a></li>
            <li class="{{ request()->get('tabFilter') == 'mostViewed' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'mostViewed']) }}">Most Viewed</a></li>
            <li class="{{ request()->get('tabFilter') == 'mostActive' ? 'active' : '' }}"><a href="{{ route('forum.index', ['category' => request()->get('category') ?? '0', 'tabFilter' => 'mostActive']) }}">Most Active Threads</a></li>
            <li><a href="/">Reset Filter</a></li>
        </ul>
    </div>
</div>
