<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\DesignPictures;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Back office: pictures for the style step of "Design your space", per room type and style. */
class DesignPictureController extends Controller
{
    public function index()
    {
        return view('admin.design-pictures', [
            'sets' => DesignPictures::SETS,
            'styles' => collect(DesignPictures::STYLES)->mapWithKeys(fn ($s) => [$s => trans("site.design.styles.$s.name", [], 'en')]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'set' => ['required', Rule::in(array_keys(DesignPictures::SETS))],
            'style' => ['required', Rule::in(DesignPictures::STYLES)],
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:12288',
        ]);
        DesignPictures::store($data['set'], $data['style'], $request->file('image'));

        return redirect()->route('admin.design.index', ['#'.$data['set']])->with('status', 'Picture saved — it is on the website now.');
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'set' => ['required', Rule::in(array_keys(DesignPictures::SETS))],
            'style' => ['required', Rule::in(DesignPictures::STYLES)],
        ]);
        DesignPictures::remove($data['set'], $data['style']);

        return redirect()->route('admin.design.index', ['#'.$data['set']])->with('status', 'Uploaded picture removed.');
    }
}
