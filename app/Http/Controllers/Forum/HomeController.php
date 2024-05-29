<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Filters\Thread\FilterByLatest;
use App\Http\Filters\Thread\FilterByMostActive;
use App\Http\Filters\Thread\FilterByMostViewed;
use App\Models\Anouncement;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $threads = Pipeline::send(Thread::query())
            ->through([
                FilterByLatest::class,
                FilterByMostActive::class,
                FilterByMostViewed::class,
            ])
            ->thenReturn()
            ->paginate(5);

        $anouncement = Anouncement::query()
            ->where('is_active', true)
            ->first();

        return view('index', compact('threads', 'anouncement'));
    }
}
