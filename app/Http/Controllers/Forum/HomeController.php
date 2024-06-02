<?php

namespace App\Http\Controllers\Forum;

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
        $users = User::orderBy('first_name', 'asc')->get();
        $thread = Thread::query()->where('slug', $slug)->first();

        return view('detail', compact('categories', 'users', 'thread'));
    }
}
