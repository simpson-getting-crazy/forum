@extends('layout.base')

@section('title', Str::title($thread->title))

@section('content')
    <div class="topics">
        <div class="topics__heading">
            <h2 class="topics__heading-title">{{ Str::title($thread->title) }}</h2>
            <div class="topics__heading-info">
                <a href="#" class="category"><i style="background-color: {{ $thread->category->color }}"></i>{{ Str::title($thread->category->name) }}</a>
            </div>
        </div>
        <div class="topics__body">
            <div class="topics__content">

                {{-- Parent --}}
                <div class="topic">
                    <div class="topic__head">
                        <div class="topic__avatar">
                            <a href="#" class="avatar"><img class="rounded-circle" src="{{ $thread->user->avatar }}" alt="avatar"></a>
                        </div>
                        <div class="topic__caption">
                            <div class="topic__name">
                                <a href="#">{{ $thread->user->getFilamentName() }}</a>
                            </div>
                            <div class="topic__date"><i class="icon-Watch_Later"></i>{{ \Carbon\Carbon::parse($thread->created_at)->format('d M, Y') }}</div>
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
                            <p>
                                {{ summernotePlacement($thread->description) }}
                            </p>
                        </div>
                        <div class="topic__footer">
                            <div class="topic__footer-likes">
                                <div>
                                    <a href="#"><i class="icon-Upvote"></i></a>
                                    <span>{{ $thread->upvote }}</span>
                                </div>
                                <div>
                                    <a href="#"><i class="icon-Downvote"></i></a>
                                    <span>{{ $thread->downvote }}</span>
                                </div>
                            </div>
                            <div class="topic__footer-share">
                                <div>
                                    <a href="#"><i class="icon-Bookmark"></i></a>
                                </div>
                                <a href="#"><i class="icon-Reply_Fill"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reply Parent Thread --}}
                @foreach($thread->parents as $repliesThread)
                    <div class="topic">
                        <div class="topic__head">
                            <div class="topic__avatar">
                                <a href="#" class="avatar"><img src="{{ $repliesThread->user->avatar }}" alt="avatar"></a>
                            </div>
                            <div class="topic__caption">
                                <div class="topic__name">
                                    <a href="#">{{ $repliesThread->user->getFilamentName() }}</a>
                                </div>
                                <div class="topic__date"><i class="icon-Watch_Later"></i>{{ \Carbon\Carbon::parse($repliesThread->created_at)->format('d M, Y') }}</div>
                            </div>
                        </div>
                        <div class="topic__content">
                            <div class="topic__text">
                                <p>{{ summernotePlacement($repliesThread->description) }}</p>
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
                                    <div>
                                        <a href="#"><i class="icon-Bookmark"></i></a>
                                    </div>
                                    <a href="#"><i class="icon-Reply_Fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Reply Other Thread --}}
                    @foreach($repliesThread->otherThreadReplies as $comment)
                        <div class="topic topic--comment">
                            <div class="topic__head">
                                <div class="topic__avatar">
                                    <a href="#" class="avatar"><img src="{{ $comment->user->avatar }}" alt="avatar"></a>
                                </div>
                                <div class="topic__caption">
                                    <div class="topic__name">
                                        <a href="#">{{ $comment->user->getFilamentName() }}</a>
                                    </div>
                                </div>
                                <a href="#" class="topic__arrow topic__arrow--up"><i class="icon-Arrow_Up"></i></a>
                            </div>
                            <div class="topic__content">
                                <div class="topic__text">
                                    <p>{{ summernotePlacement($comment->description) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
            <div class="topics__calendar">
                <div class="calendar">
                    <div class="calendar__center">
                        <div class="calendar__first">Jun 12</div>
                        <div class="calendar__range">
                            <div class="calendar__current">
                                <span>Jun 17</span>
                            </div>
                        </div>
                        <div class="calendar__last">6h ago</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        $('.comments-editor').each(function () {
            var placeholder = $(this).data('placeholder')
            var userLists = {!! json_encode($users->toArray()) !!}
            var mentionData = []

            $(this).summernote({
                height: 200,
                placeholder: placeholder,
                tabsize: 2,
                lang: 'en-EN',
                hint: {
                    mentions: userLists,
                    match: /\B@(\w*)$/,
                    search: function (keyword, callback) {
                        callback($.grep(this.mentions, function (item) {
                            return item.first_name.toLowerCase().indexOf(keyword.toLowerCase()) === 0;
                        }));
                    },
                    template: function (item) {
                        return `<img src="${item.avatar}" width="20" /> ${item.first_name}`;
                    },
                    content: function (item) {
                        mentionData.push(item.id);
                        $('#mentionInput').val(JSON.stringify(mentionData));
                        return $(`<span class="fw-bold">@${item.first_name}&nbsp;</span>`)[0];
                    }
                }
            })
        })
    </script>
@endpush
