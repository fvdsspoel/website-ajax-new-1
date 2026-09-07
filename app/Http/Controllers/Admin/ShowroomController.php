<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowroomLocation;
use Illuminate\Http\Request;

class ShowroomController extends Controller
{
    public function index()
    {
        return view('admin.showrooms.index', ['locations' => ShowroomLocation::all()]);
    }

    public function create()
    {
        return view('admin.showrooms.form', ['location' => new ShowroomLocation()]);
    }

    public function store(Request $request)
    {
        ShowroomLocation::create($this->validated($request));
        return redirect()->route('admin.showrooms.index')->with('status', 'Location added.');
    }

    public function edit(ShowroomLocation $showroom)
    {
        return view('admin.showrooms.form', ['location' => $showroom]);
    }

    public function update(Request $request, ShowroomLocation $showroom)
    {
        $showroom->update($this->validated($request));
        return redirect()->route('admin.showrooms.index')->with('status', 'Location updated.');
    }

    public function destroy(ShowroomLocation $showroom)
    {
        $showroom->delete();
        return back()->with('status', 'Location removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:50',
        ]);

        foreach (['is_headquarters', 'is_factory', 'is_showroom', 'is_upcoming', 'is_active'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        return $data;
    }
}
