@extends('layout.base')

@section('title', 'Home')

@section('content')
    <div class="posts">
        <div class="posts__head">
            <div class="posts__topic">Topic</div>
            <div class="posts__category">Category</div>
            <div class="posts__users">Users</div>
            <div class="posts__replies">Replies</div>
            <div class="posts__views">Views</div>
            <div class="posts__activity">Activity</div>
        </div>
        <div class="posts__body">

            @if (Auth::check())
                @if (\Carbon\Carbon::parse(auth()->user()->created_at)->timestamp <= now()->timestamp)
                    <div class="posts__item bg-fef2e0">
                        <div class="posts__section-left">
                            <div class="posts__topic">
                                <div class="posts__content">
                                    <a href="#">
                                        <h3>
                                            <i>
                                                <img src="{{ asset('bootstrap-forum/fonts/icons/main/Pinned.svg') }}"
                                                    alt="Pinned">
                                            </i>
                                            {{ Str::title($anouncement->title) }}
                                        </h3>
                                    </a>
                                    <p>
                                        {{ $anouncement->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="posts__section-right">
                        </div>
                    </div>
                @endif
            @endif

            @foreach ($threads as $thread)
                <div class="posts__item">
                    <div class="posts__section-left">
                        <div class="posts__topic">
                            <div class="posts__content">
                                <a href="#">
                                    <h3>{{ Str::title($thread->title) }}</h3>
                                </a>
                            </div>
                        </div>
                        <div class="posts__category">
                            <a href="#" class="category">
                                <i style="background-color: {{ $thread->category->color }}"></i>
                                {{ Str::title($thread->category->name) }}
                            </a>
                        </div>
                    </div>
                    <div class="posts__section-right">
                        <div class="posts__users js-dropdown">
                            @forelse($thread->getUsersByLastActivityForThreads() as $parent)
                                <div>
                                    <a href="#" class="avatar"><img
                                            src="{{ $parent->user->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/T.svg') }}"
                                            alt="avatar" class="rounded-circle" data-dropdown-btn="user-t"></a>
                                    <div class="posts__users-dropdown dropdown dropdown--user" data-dropdown-list="user-t">
                                        <div class="dropdown__user">
                                            <a href="#" class="dropdown__user-label">
                                                <img src="{{ $parent->user->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/T.svg') }}"
                                                    alt="avatar" class="rounded-circle">
                                            </a>
                                            <div class="dropdown__user-nav">
                                                <a href="#"><i class="icon-Add_User"></i></a>
                                                <a href="#"><i class="icon-Message"></i></a>
                                            </div>
                                            <div class="dropdown__user-info">
                                                <a href="#">{{ $parent->user->getFilamentName() }}</a>
                                                <p>
                                                    {{ $parent->user->getRelatedUserLastPost() }} <br>
                                                    {{ $parent->user->getUserJoinedAt() }}
                                                </p>
                                            </div>
                                            <div class="dropdown__user-statistic">
                                                <div>Threads -
                                                    <span>{{ $parent->user->getRelatedUserThreads()->count() }}</span>
                                                </div>
                                                <div>Posts -
                                                    <span>{{ $parent->user->getRelatedUserPosts()->count() }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <a href="#" class="avatar"><img
                                            src="{{ $thread->user->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/T.svg') }}"
                                            alt="avatar" class="rounded-circle" data-dropdown-btn="user-t"></a>
                                    <div class="posts__users-dropdown dropdown dropdown--user" data-dropdown-list="user-t">
                                        <div class="dropdown__user">
                                            <a href="#" class="dropdown__user-label">
                                                <img src="{{ $thread->user->avatar ?? asset('bootstrap-forum/fonts/icons/avatars/T.svg') }}"
                                                    alt="avatar" class="rounded-circle">
                                            </a>
                                            <div class="dropdown__user-nav">
                                                <a href="#"><i class="icon-Add_User"></i></a>
                                                <a href="#"><i class="icon-Message"></i></a>
                                            </div>
                                            <div class="dropdown__user-info">
                                                <a href="#">{{ $thread->user->getFilamentName() }}</a>
                                                <p>
                                                    {{ $thread->user->getRelatedUserLastPost() }} <br>
                                                    {{ $thread->user->getUserJoinedAt() }}
                                                </p>
                                            </div>
                                            <div class="dropdown__user-statistic">
                                                <div>Threads -
                                                    <span>{{ $thread->user->getRelatedUserThreads()->count() }}</span>
                                                </div>
                                                <div>Posts -
                                                    <span>{{ $thread->user->getRelatedUserPosts()->count() }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="posts__replies">{{ $thread->replies }}</div>
                        <div class="posts__views">{{ $thread->views }}</div>
                        <div class="posts__activity">{{ compactDiffForHumans($thread->last_activity) }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $threads->links('components.pagination') }}

    </div>
@endsection
