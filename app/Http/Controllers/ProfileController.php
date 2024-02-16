<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $authUser = User::where('id', auth()->user()->id)->first();
        $oldFile = $authUser->user_photo_path;

        $file = $request->file('profileImage');

        // dd(public_path() . '/profile/');

        if (isset($file)) {
            $fileName = $file->hashName();
            if (Storage::exists('public/profile/' . $oldFile)) {
                Storage::delete('public/profile/' . $oldFile);

                $file->storeAs('public/profile/', $fileName);
                User::where('id', auth()->user()->id)->update([
                    'user_photo_path' => 'profile/' . $fileName,
                ]);
            }

            $file->storeAs('public/profile/', $fileName);
            User::where('id', auth()->user()->id)->update([
                'user_photo_path' => 'profile/' . $fileName,
            ]);
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
