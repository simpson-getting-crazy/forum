<?php

namespace App\Http\Controllers\Forum\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyThreadController extends Controller
{
    public function index(): View
    {
        $threads = Auth::user()->getRelatedUserThreads(withPagination: true);

        return view('forum.dashboard.thread.index', compact('threads'));
    }
}
