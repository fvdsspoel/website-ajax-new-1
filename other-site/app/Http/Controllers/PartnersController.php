<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PartnersService;
use Illuminate\Support\Facades\DB;

class PartnersController extends Controller
{
  private $partnersService;

  public function __construct(PartnersService $partnersService){

    $this->partnersService = $partnersService;
  }

  public function index(Request $request){
  	$keyword = $request->keyword;
    $results = $this->partnersService->list($keyword);
    return view('partners.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    return view('partners.create',compact('data'));
  }

  public function edit($id,Request $request){
    $data = $this->partnersService->getData($id);
    return view('partners.create',compact('data'));
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {

        $data = array(
                      'image' => request('image'),
                      'name' => request('name'),
                  );

        if(request('id')){

            $data['id'] = request('id');
            $data['multi_selected_image'] = request('multi_selected_image');

            $this->partnersService->update($data);
        
        }else{

            $this->partnersService->create($data);
        
        }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function delete(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->partnersService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }
}