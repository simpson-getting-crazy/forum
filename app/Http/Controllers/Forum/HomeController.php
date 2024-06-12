<?php

namespace App\Http\Controllers\Forum;

use App\Actions\MentionProcess;
use App\Models\User;
use App\Models\Thread;
use App\Models\Category;
use Illuminate\View\View;
use App\Models\Anouncement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Pipeline;
use App\Http\Filters\Thread\FilterByLatest;
use App\Http\Filters\Thread\FilterByCategory;
use App\Http\Filters\Thread\FilterByMostActive;
use App\Http\Filters\Thread\FilterByMostViewed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $threads = Pipeline::send(Thread::query()
            ->whereNull('parent_id')
            ->whereNull('other_thread_replies'))
            ->through([
                FilterByLatest::class,
                FilterByMostActive::class,
                FilterByMostViewed::class,
                FilterByCategory::class,
            ])
            ->thenReturn()
            ->paginate(5);

        $anouncement = Anouncement::query()
            ->where('is_active', true)
            ->first();

        return view('index', compact('threads', 'anouncement'));
    }

    public function detail(string $slug): View
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $thread = Thread::query()->where('slug', $slug)->first();
        $userMentions = function ($thread) {
            $parentUser = $thread->parents->map(fn ($item) => $item->user);

            return $thread
                ->parents
                ->map(fn ($item) => $item->otherThreadReplies->map(fn ($item) => $item->user))
                ->flatten(1)
                ->merge($parentUser)
                ->unique();
        };

        $users = $userMentions($thread)->values();

        $thread->update(['views' => $thread->views + 1]);

        return view('detail', compact('categories', 'users', 'thread'));
    }

    public function submitReplyThread(Request $request, string $slug): RedirectResponse
    {
        DB::beginTransaction();
        try {

            $validateRequest = $request->validate([
                'description' => ['required', 'string']
            ]);

            $thread = Thread::where('slug', $slug)->lockForUpdate()->first();

            $createdThread = Thread::create([
                'user_id' => Auth::id(),
                'category_id' => $thread->category->id,
                'parent_id' => $thread->id,
                'other_replies_thread' => null,
                'title' => null,
                'slug' => null,
                'description' => $validateRequest['description'],
                'visibility' => 'all',
                'last_activity' => now(),
            ]);

            if (isset($request->mentions)) {
                MentionProcess::execute($request->mentions, $createdThread);
            }

            $thread->update([
                'replies' => $thread->replies + 1,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Thread Successfully Created');
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
        }
    }

    public function submitReplyComment(Request $request, string $slug): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validateRequest = $request->validate([
                'other_thread_replies' => ['required', 'string', 'exists:users,id'],
                'description' => ['required', 'string']
            ]);

            $thread = Thread::where('slug', $slug)->lockForUpdate()->first();

            $createdThread = Thread::create([
                'user_id' => Auth::id(),
                'category_id' => $thread->category->id,
                'parent_id' => null,
                'other_thread_replies' => $validateRequest['other_thread_replies'],
                'title' => null,
                'slug' => null,
                'description' => $validateRequest['description'],
                'visibility' => 'all',
                'last_activity' => now(),
            ]);

            if (isset($request->mentions)) {
                MentionProcess::execute($request->mentions, $createdThread);
            }

            $thread->update([
                'replies' => $thread->replies + 1,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Comment Successfully Created');
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
        }
    }

    public function submitBookmark(Request $request, string $slug, string $threadId): RedirectResponse
    {
        $thread = Thread::where('id', $threadId)->first();

        $thread->bookmarkedThread()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Thread Was Bookmarked');
    }

    public function submitVotes(Request $request, string $slug, string $threadId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $thread = Thread::where('slug', $slug)->lockForUpdate()->first();
            $replyThread = Thread::where('id', $threadId)->lockForUpdate()->first();

            if (!$replyThread->checkIfVoted()) {
                $replyThread->votedThread()->create([
                    'user_id' => Auth::id(),
                    'type' => $request->type,
                ]);

                $replyThread->update([
                    'upvote' => $request->type == 'up'
                        ? $replyThread->upvote + 1
                        : $replyThread->upvote,
                    'downvote' => $request->type == 'down'
                        ? $replyThread->downvote + 1
                        : $replyThread->downvote,
                ]);

                $thread->update([
                    'upvote' => $request->type == 'up'
                        ? $thread->upvote + 1
                        : $thread->upvote,
                    'downvote' => $request->type == 'down'
                        ? $thread->downvote + 1
                        : $thread->downvote,
                ]);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('success', 'Thread Was Voted');
            }

            return redirect()
                ->back()
                ->with('error', 'You`ve been already voted!');
        } catch (\Exception $ex) {
            DB::rollBack();

            dd($ex);
        }
    }

}
