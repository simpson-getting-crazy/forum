<?php

namespace App\Http\Controllers\Auth;

use App\BulkActions\GenerateAvatar;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validateRequest = $request->validate([
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'username' => ['required', 'string', 'unique:users,username'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
                'terms_condition' => ['required']
            ], ['terms_condition' => 'The terms condition field is need to be checked']);

            $validateRequest['password'] = bcrypt($validateRequest['password']);

            $avatarUrl = GenerateAvatar::make($validateRequest['first_name'], "forum/avatar/{$validateRequest['first_name']}.png");

            $user = User::create($validateRequest + ['avatar' => $avatarUrl]);

            Auth::login($user);

            DB::commit();

            return redirect()->intended();
        } catch (\Exception $ex) {
            DB::rollBack();

            dd($ex);
        }
    }
}
