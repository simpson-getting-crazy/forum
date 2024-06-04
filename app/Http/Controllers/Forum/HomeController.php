<?php

namespace App\Http\Controllers\Forum;

use App\BulkActions\MentionProcess;
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
        $users = User::where('is_admin', false)->orderBy('first_name', 'asc')->get();
        $thread = Thread::query()->where('slug', $slug)->first();

        $thread->update(['views' => $thread->views + 1]);

        return view('detail', compact('categories', 'users', 'thread'));
    }

    public function submitReplyThread(Request $request, string $slug): RedirectResponse
    {
        $validateRequest = $request->validate([
            'description' => ['required', 'string']
        ]);

        $thread = Thread::where('slug', $slug)->first();

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

        return redirect()
            ->back()
            ->with('success', 'Thread Successfully Created');
    }

    public function submitReplyComment(Request $request, string $slug): RedirectResponse
    {
        $validateRequest = $request->validate([
            'other_thread_replies' => ['required', 'string', 'exists:users,id'],
            'description' => ['required', 'string']
        ]);

        $thread = Thread::where('slug', $slug)->first();

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

        return redirect()
            ->back()
            ->with('success', 'Comment Successfully Created');
    }
}
