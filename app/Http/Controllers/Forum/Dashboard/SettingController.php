<?php

namespace App\Http\Controllers\Forum\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('forum.dashboard.setting.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $validatedRequest = $request->validate([
            'lang' => ['required']
        ]);

        session()->put('lang', $validatedRequest['lang']);

        return redirect()
            ->back();
    }
}
