<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', ['products' => Product::orderBy('category')->get()]);
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(), 'categories' => Product::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['image_url'] = $this->handleUpload($request);
        Product::create($validated);
        return redirect()->route('admin.products.index')->with('status', 'Product added.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Product::CATEGORIES]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validated($request);
        if ($upload = $this->handleUpload($request)) {
            $validated['image_url'] = $upload;
        }
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('status', 'Product removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(Product::CATEGORIES)),
            'description' => 'nullable|string|max:2000',
        ]);
    }

    private function handleUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }
        $path = $request->file('image')->store('products', 'public');
        return Storage::url($path);
    }
}
