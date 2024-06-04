@extends('layout.base', ['commentsForm' => true])

@section('title', Str::title($thread->title))

@section('content')
    <div class="topics">
        <div class="topics__heading">
            <h2 class="topics__heading-title">{{ Str::title($thread->title) }}</h2>
            <div class="topics__heading-info">
                <a href="#" class="category"><i
                        style="background-color: {{ $thread->category->color }}"></i>{{ Str::title($thread->category->name) }}</a>
            </div>
        </div>
        <div class="topics__body">
            <div class="topics__content">

                {{-- Parent --}}
                <div class="topic">
                    <div class="topic__head">
                        <div class="topic__avatar">
                            <a href="#" class="avatar"><img class="rounded-circle" src="{{ $thread->user->avatar }}"
                                    alt="avatar"></a>
                        </div>
                        <div class="topic__caption">
                            <div class="topic__name">
                                <a href="#">{{ $thread->user->getFilamentName() }}</a>
                            </div>
                            <div class="topic__date"><i
                                    class="icon-Watch_Later"></i>{{ \Carbon\Carbon::parse($thread->created_at)->format('d M, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="topic__content">
                        <div class="topic__text">
                            <div class="topic topic--answer">
                                <div class="topic__content">
                                    <div class="topic__text">
                                        <p>{{ Str::title($thread->title) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                {!! summernotePlacement($thread->description) !!}
                            </div>
                        </div>
                        <div class="topic__footer">
                            <div class="topic__footer-likes"></div>
                            <div class="topic__footer-share">
                                <a href="#"><i class="fa fa-exclamation-circle" style="font-size: 2.5rem"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reply Parent Thread --}}
                @foreach ($thread->parents as $repliesThread)
                    <div class="topic">
                        <div class="topic__head">
                            <div class="topic__avatar">
                                <a href="#" class="avatar"><img src="{{ $repliesThread->user->avatar }}"
                                        alt="avatar"></a>
                            </div>
                            <div class="topic__caption">
                                <div class="topic__name">
                                    <a href="#">{{ $repliesThread->user->getFilamentName() }}</a>
                                </div>
                                <div class="topic__date"><i
                                        class="icon-Watch_Later"></i>{{ \Carbon\Carbon::parse($repliesThread->created_at)->format('d M, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="topic__content">
                            <div class="topic__text">
                                <div>{!! summernotePlacement($repliesThread->description) !!}</div>
                            </div>
                            <div class="topic__footer">
                                <div class="topic__footer-likes">
                                    <div>
                                        <a href="#"><i class="icon-Upvote"></i></a>
                                        <span>{{ $repliesThread->upvote }}</span>
                                    </div>
                                    <div>
                                        <a href="#"><i class="icon-Downvote"></i></a>
                                        <span>{{ $repliesThread->downvote }}</span>
                                    </div>
                                </div>
                                <div class="topic__footer-share">
                                    <a href="#"><i class="fa fa-exclamation-circle" style="font-size: 2.5rem"></i></a>
                                    <div>
                                        <a href="#"><i class="icon-Bookmark"></i></a>
                                    </div>
                                    <a href="#" class="replyBtn" data-parent-id="{{ $repliesThread->id }}"><i class="icon-Reply_Fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="replyBox" data-reply-thread="{{ $repliesThread->id }}"></div>

                    {{-- Reply Other Thread --}}
                    @foreach ($repliesThread->otherThreadReplies as $comment)
                        <div class="topic topic--comment">
                            <div class="topic__head">
                                <div class="topic__avatar">
                                    <a href="#" class="avatar"><img src="{{ $comment->user->avatar }}"
                                            alt="avatar"></a>
                                </div>
                                <div class="topic__caption">
                                    <div class="topic__name">
                                        <a href="#">{{ $comment->user->getFilamentName() }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="topic__content">
                                <div class="topic__text">
                                    <div>{!! summernotePlacement($comment->description) !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
            <div class="topics__calendar">
                <div class="calendar">
                    <div class="calendar__center">
                        <div class="calendar__first">{{ \Carbon\Carbon::parse($thread->created_at)->format('M, d') }}</div>
                        <div class="calendar__range">
                            <div class="calendar__current">
                                <span>{{ \Carbon\Carbon::parse($thread->parents[$thread->parents()->count() - 1]->created_at)->format('M, d') }}</span>
                            </div>
                        </div>
                        <div class="calendar__last">{{ compactDiffForHumans($thread->parents[$thread->parents()->count() - 1]->created_at) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::check())
        <div class="topics__title mb-4"><i class="icon-Reply_Fill"></i>My Answer</div>
            <div class="row">
                <div class="col-10">
                    <span>
                        Create answers to answer the question rather than ask for clarification or comment on the question, use
                        comments for that purpose.
                    </span>
                    <div class="topic mt-4">
                        <div class="topic__head">
                            <div class="topic__avatar">
                                <a href="#" class="avatar"><img class="rounded-circle" src="{{ auth()->user()->avatar }}"
                                        alt="avatar"></a>
                            </div>
                            <div class="topic__caption">
                                <div class="topic__name">
                                    <a href="#">{{ auth()->user()->getFilamentName() }}</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('forum.submit.reply', $thread->slug) }}" method="POST">
                            @csrf
                            <input id="mentionInput" type="hidden" name="mentions">
                            <div class="topic__content">
                                <div class="topic__text">
                                    <div class="create__section create__textarea">
                                        <textarea rows="5" class="form-control comments-editor" data-placeholder="My Answer" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="topic__footer">
                                    <div class="topic__footer-likes"></div>
                                    <div class="topic__footer-share">
                                        <button type="submit" class="create__btn-create btn btn--type-02">
                                            Submit Answer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-10">
                    <div class="topic mt-4">
                        {{-- <div class="topic__head"></div> --}}
                        <div class="topic__content">
                            <h4 class="text-center">Do you know the answer?</h4>
                            <p class="text-center">
                                Come join us in DevSpaces, to enjoy the existing features
                            </p>
                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <a href="{{ route('forum_auth.login.index') }}" class="btn-base">Login</a>
                                <a href="{{ route('forum_auth.register.index') }}" class="btn btn--type-02">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endsection

    @push('script')
        <script>
            applySummernoteReplyBox()
        </script>

        <script>
            $(document).ready(function () {
                $('.replyBtn').each(function () {
                    $(this).click(function (e) {
                        e.preventDefault()

                        let parentId = $(this).data('parent-id')
                        let selectedReplyBox = $(`div[data-reply-thread="${parentId}"]`)

                        let html = `
                            <div class="topic topic--comment replyBoxes">
                                <div class="topic__head">
                                    <div class="topic__avatar">
                                        <a href="#" class="avatar"><img class="rounded-circle" src="{{ auth()->user()->avatar }}"
                                                alt="avatar"></a>
                                    </div>
                                    <div class="topic__caption">
                                        <div class="topic__name">
                                            <a href="#">{{ auth()->user()->getFilamentName() }}</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('forum.submit.comment', $thread->slug) }}" method="POST">
                                    @csrf
                                    <input id="mentionInput" type="hidden" name="mentions">
                                    <input type="hidden" name="other_thread_replies" value="${parentId}">
                                    <div class="topic__content">
                                        <div class="topic__text">
                                            <div class="create__section create__textarea">
                                                <textarea rows="5" class="form-control comments-editor" data-placeholder="My Answer" name="description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="topic__footer">
                                            <div class="topic__footer-likes"></div>
                                            <div class="topic__footer-share">
                                                <button type="submit" class="create__btn-create btn btn--type-02">
                                                    Submit Answer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        `
                        $('.replyBoxes').remove()

                        selectedReplyBox.append(html)
                        applySummernoteReplyBox()
                    })
                })
            })
        </script>
    @endpush
