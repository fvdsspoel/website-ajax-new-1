<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class CodeHelpersController extends Controller
{
   
    public function uploadImage(Request $request){

        if (request('imageFile')) {

            $path = Storage::disk('public')->put('articles', request('imageFile'));
            $image='/storage/'.$path;

            return response()->json($image);

        }else{
            return response()->json('error');
        }
    }
}
