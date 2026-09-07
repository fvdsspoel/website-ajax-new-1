<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('admin.portfolio.index', [
            'items' => PortfolioItem::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.portfolio.form', [
            'item' => new PortfolioItem(),
            'categories' => PortfolioItem::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['image_url'] = $this->handleUpload($request);
        PortfolioItem::create($validated);
        return redirect()->route('admin.portfolio.index')->with('status', 'Project added.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        return view('admin.portfolio.form', [
            'item' => $portfolio,
            'categories' => PortfolioItem::CATEGORIES,
        ]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $validated = $this->validated($request);
        if ($upload = $this->handleUpload($request)) {
            $validated['image_url'] = $upload;
        }
        $portfolio->update($validated);
        return redirect()->route('admin.portfolio.index')->with('status', 'Project updated.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        $portfolio->delete();
        return back()->with('status', 'Project removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(PortfolioItem::CATEGORIES)),
            'description' => 'nullable|string|max:2000',
            'is_featured' => 'nullable|boolean',
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }

    private function handleUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }
        $path = $request->file('image')->store('portfolio', 'public');
        return Storage::url($path);
    }
}
