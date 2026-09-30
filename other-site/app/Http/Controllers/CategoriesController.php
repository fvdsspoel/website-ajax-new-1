<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoriesService;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    private $categoriesService;

    public function __construct(CategoriesService $categoriesService){

      $this->categoriesService = $categoriesService;
    }

    public function index(Request $request)
    {
    	$keyword = $request->keyword;
      $results = $this->categoriesService->list($keyword);
      return view('categories.index',compact('keyword','results'));
    }

    public function create(Request $request)
    {
    	$data = null;
        return view('categories.create',compact('data'));
    }

    public function edit($id,Request $request)
    {
        $data = $this->categoriesService->getData($id);
        return view('categories.create',compact('data'));
    }

    public function getSubCategory(Request $request)
    {
        $data = $this->categoriesService->getSubCategory(request('id'));
        return response()->json($data);
    }

    public function store(Request $request){ 
    
      $has_exceptions = DB::transaction(function() use($request) {

          $data = array(
                        'image' => request('image'),
                        'name' => request('name'),
                        'description' => request('description'),
                        'sub_category_id' => request('sub_category_id'),
                        'category' => request('category'),
                        'multi_selected_id' => request('multi_selected_id'),
                        'sub_category' => request('sub_category'),
                        'multi_selected' => request('multi_selected'),
                        'category_type' => request('category_type')
                    );

          if(request('id')){

              $data['id'] = request('id');
              $data['sub_category_id'] = request('sub_category_id');
              $data['multi_selected_image'] = request('multi_selected_image');

              $this->categoriesService->update($data);
          
          }else{

              $this->categoriesService->create($data);
          
          }

      });

      // Return the transaction response.
      $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
      return response()->json($response);
    }

    public function delete(Request $request){
      
      $has_exceptions = DB::transaction(function() use($request) {
          
          $id = request('id');
          $this->categoriesService->delete($id);
      });

      // Return the transaction response.
      $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
      return response()->json($response);
    }
}
