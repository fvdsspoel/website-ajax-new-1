<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminInvite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

/** A new person types the one-time code from the owner and chooses their own e-mail and password. */
class JoinController extends Controller
{
    public function show()
    {
        return view('admin.join');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(10)],
        ], [], ['code' => 'code']);

        $invite = AdminInvite::findOpen($data['code']);
        if (! $invite) {
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['code' => 'This code is wrong, already used or expired. Ask the owner for a new code.']);
        }

        $user = User::create([
            'name' => $data['name'], 'email' => strtolower($data['email']), 'password' => $data['password'],
            'role' => $invite->role, 'last_login_at' => now(),
        ]);
        $invite->update(['used_at' => now(), 'used_by' => $user->id]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.texts.index')->with('status', 'Welcome, '.$user->name.'! Your login is ready.');
    }
}
