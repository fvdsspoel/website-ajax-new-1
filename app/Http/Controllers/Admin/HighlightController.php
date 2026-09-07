<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    public function index()
    {
        return view('admin.highlights.index', ['highlights' => Highlight::latest('published_at')->get()]);
    }

    public function create()
    {
        return view('admin.highlights.form', ['highlight' => new Highlight()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['image_url'] = $this->handleUpload($request);
        Highlight::create($validated);
        return redirect()->route('admin.highlights.index')->with('status', 'Highlight added.');
    }

    public function edit(Highlight $highlight)
    {
        return view('admin.highlights.form', ['highlight' => $highlight]);
    }

    public function update(Request $request, Highlight $highlight)
    {
        $validated = $this->validated($request);
        if ($upload = $this->handleUpload($request)) {
            $validated['image_url'] = $upload;
        }
        $highlight->update($validated);
        return redirect()->route('admin.highlights.index')->with('status', 'Highlight updated.');
    }

    public function destroy(Highlight $highlight)
    {
        $highlight->delete();
        return back()->with('status', 'Highlight removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string|max:2000',
            'published_at' => 'nullable|date',
        ]);
    }

    private function handleUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }
        $path = $request->file('image')->store('highlights', 'public');
        return Storage::url($path);
    }
}
