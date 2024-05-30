@extends('layout.base', ['navigation' => false])

@section('title', 'Thread')

@section('content')
    <div class="posts">

        <div class="posts__body">
            <div class="row my-4">
                <div class="card">
                    @include('forum.layout.tabs')
                    <div class="col-12">
                        <div class="base-card">
                            @foreach($threads as $thread)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="base-card">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="posts__content">
                                                <a href="#">
                                                    <h3>{{ Str::title($thread->title) }}</h3>
                                                </a>
                                            </div>
                                            <div >
                                                <a href="#" class="category">
                                                    <i style="background-color: {{ $thread->category->color }}"></i>
                                                    {{ Str::title($thread->category->name) }}
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div>{{ $thread->replies.' Replies' }}</div>
                                                <div>{{ $thread->views.' Views' }}</div>
                                                <div>{{ compactDiffForHumans($thread->last_activity) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
