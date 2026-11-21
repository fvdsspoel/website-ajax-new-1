<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminInvite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Owner only: who has a login, give a code to a new person, change or remove access. */
class TeamController extends Controller
{
    public function index()
    {
        return view('admin.team', [
            'users' => User::orderByRaw("role = 'owner' desc")->orderBy('name')->get(),
            'invites' => AdminInvite::whereNull('used_at')->where('expires_at', '>', now())->latest()->get(),
        ]);
    }

    public function invite(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:120', 'role' => ['required', Rule::in(User::ROLES)]]);
        [$invite, $code] = AdminInvite::make($data['name'], $data['role'], $request->user()->id);

        return redirect()->route('admin.team.index')->with('new_code', ['name' => $invite->name, 'code' => $code, 'role' => $invite->role]);
    }

    public function cancel(AdminInvite $invite)
    {
        $invite->delete();

        return back()->with('status', 'Code cancelled.');
    }

    public function role(Request $request, User $user)
    {
        $data = $request->validate(['role' => ['required', Rule::in(User::ROLES)]]);
        if ($user->is($request->user()) || ($user->isOwner() && $data['role'] !== 'owner' && User::where('role', 'owner')->count() < 2)) {
            return back()->withErrors(['role' => 'There must always be at least one owner, and you cannot change your own role.']);
        }
        $user->update(['role' => $data['role']]);

        return back()->with('status', $user->name.' is now '.$data['role'].'.');
    }

    public function remove(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You cannot remove your own login.']);
        }
        if ($user->isOwner() && User::where('role', 'owner')->count() < 2) {
            return back()->withErrors(['user' => 'There must always be at least one owner.']);
        }
        $user->delete();

        return back()->with('status', 'Login of '.$user->name.' removed.');
    }
}
