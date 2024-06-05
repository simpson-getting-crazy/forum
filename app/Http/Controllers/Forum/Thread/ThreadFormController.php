<?php

namespace App\Http\Controllers\Forum\Thread;

use App\Actions\ProcessEditorFileUpload;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ThreadFormController extends Controller
{
    public function create(): View
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $users = User::orderBy('first_name', 'asc')->get();

        return view('forum.thread.form', compact('categories', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validateRequest = $request->validate([
            'title' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'visibility' => ['required', 'in:all,friends']
        ]);

        $editorProcess = ProcessEditorFileUpload::make($validateRequest['description']);

        Thread::create([
            'user_id' => Auth::id(),
            'category_id' => $validateRequest['category_id'],
            'title' => $validateRequest['title'],
            'description' => $editorProcess->value,
            'visibility' => $validateRequest['visibility'],
            'last_activity' => now(),
        ]);

        return redirect()
            ->route('forum.my_thread.index');
    }
}
