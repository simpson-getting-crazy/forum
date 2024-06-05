<?php

namespace App\Http\Controllers\Forum\Dashboard;

use App\Actions\UploadImage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('forum.dashboard.profile.index', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $authUserId = Auth::id();
        $user = User::find($authUserId);

        $validateRequest = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.$authUserId],
            'new_password' => ['nullable', 'string', 'min:8'],
            'avatar' => ['nullable', function ($attribute, $value, $fail) use ($request) {
                $image = getimagesize($request->avatar);
                $aspectRatio = getAspectRatio($image[0], $image[1]);

                if ($aspectRatio['aspect'] != '1:1') {
                    $fail('The avatar image aspect ratio must be 1:1');
                }
            }]
        ]);

        $user->update([
            'first_name' => $validateRequest['first_name'],
            'last_name' => $validateRequest['last_name'],
            'email' => $validateRequest['email'],
            'password' => !is_null($validateRequest['new_password'])
                ? bcrypt($validateRequest['new_password'])
                : $user->password,
            'avatar' => isset($validateRequest['avatar'])
                ? UploadImage::make($validateRequest['avatar'], 'forum/profile')
                : $user->avatar,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Update Profile Success');
    }
}
