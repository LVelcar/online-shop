<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for editing the profile.
     */
    public function edit(Request $request)
    {
        return view('profiles.edit')->with([
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the profile.
     */
    public function update(ProfileRequest $request)
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

}
