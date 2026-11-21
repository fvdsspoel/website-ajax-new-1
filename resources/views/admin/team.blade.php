@extends('admin.layout')
@section('title', 'Team & login codes')
@section('content')
<h1>Team &amp; login codes</h1>
<p class="lead">Give a new person a one-time code. They open <b>{{ url('/admin/join') }}</b>, type the code and choose their own e-mail and password — you never need to know it. A code works once and expires after {{ \App\Models\AdminInvite::DAYS_VALID }} days.</p>

@if ($new = session('new_code'))
    <div class="new-code" role="status">
        <div>Code for <b>{{ $new['name'] }}</b> ({{ $new['role'] }}) — send it by Viber or say it on the phone. It is shown only now.</div>
        <div class="code">{{ $new['code'] }}</div>
        <div style="opacity:.8;font-size:14px">Link to send with it: {{ url('/admin/join') }}</div>
    </div>
@endif

<div class="card">
    <h2 style="margin:0 0 4px;font-size:18px">Make a new code</h2>
    <form method="POST" action="{{ route('admin.team.invite') }}" class="admin-actions" style="gap:10px;margin-top:10px">
        @csrf
        <input type="text" name="name" placeholder="Name of the person" required maxlength="120" style="max-width:260px">
        <select name="role" style="max-width:300px">
            <option value="editor">Editor — website texts and projects</option>
            <option value="owner">Owner — everything + give codes</option>
        </select>
        <button type="submit" class="btn">Make code</button>
    </form>
</div>

<h2 style="font-size:18px">Who has a login</h2>
<table class="admin-table">
    <thead><tr><th>Name</th><th>E-mail</th><th>Role</th><th>Last login</th><th></th></tr></thead>
    <tbody>
    @foreach ($users as $u)
        <tr>
            <td><b>{{ $u->name }}</b> @if($u->is(auth()->user()))<span class="muted">(you)</span>@endif</td>
            <td>{{ $u->email }}</td>
            <td><span class="tag {{ $u->isOwner() ? 'tag--owner' : '' }}">{{ $u->role }}</span></td>
            <td class="muted">{{ $u->last_login_at?->diffForHumans() ?? '—' }}</td>
            <td>
                @unless ($u->is(auth()->user()))
                <div class="admin-actions">
                    <form method="POST" action="{{ route('admin.team.role', $u) }}">@csrf @method('PATCH')
                        <input type="hidden" name="role" value="{{ $u->isOwner() ? 'editor' : 'owner' }}">
                        <button type="submit" class="btn btn--ghost btn--sm">Make {{ $u->isOwner() ? 'editor' : 'owner' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.team.remove', $u) }}" onsubmit="return confirm('Remove the login of {{ $u->name }}? They can no longer log in.')">@csrf @method('DELETE')
                        <button type="submit" class="btn btn--danger">Remove login</button>
                    </form>
                </div>
                @endunless
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2 style="font-size:18px;margin-top:26px">Codes not used yet</h2>
@if ($invites->isEmpty())
    <p class="muted">None.</p>
@else
<table class="admin-table">
    <thead><tr><th>For</th><th>Role</th><th>Valid until</th><th></th></tr></thead>
    <tbody>
    @foreach ($invites as $i)
        <tr>
            <td>{{ $i->name }}</td>
            <td><span class="tag {{ $i->role === 'owner' ? 'tag--owner' : '' }}">{{ $i->role }}</span></td>
            <td class="muted">{{ $i->expires_at->format('d M Y H:i') }}</td>
            <td><form method="POST" action="{{ route('admin.team.cancel', $i) }}">@csrf @method('DELETE')<button class="btn btn--danger" type="submit">Cancel code</button></form></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
@endsection
