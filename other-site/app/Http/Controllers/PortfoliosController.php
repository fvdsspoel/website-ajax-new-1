<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PortfoliosService;
use Illuminate\Support\Facades\DB;

class PortfoliosController extends Controller
{
  private $portfoliosService;

  public function __construct(PortfoliosService $portfoliosService){

    $this->portfoliosService = $portfoliosService;
  }

  public function index(Request $request){
  	$keyword = $request->keyword;
    $results = $this->portfoliosService->list($keyword);
    return view('portfolios.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    return view('portfolios.create',compact('data'));
  }

  public function edit($id,Request $request){
    $data = $this->portfoliosService->getData($id);
    return view('portfolios.create',compact('data'));
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {

        $data = array(
                      'image' => request('image'),
                      'description' => request('description'),
                      'name' => request('name'),
                  );

        if(request('id')){

            $data['id'] = request('id');
            $data['multi_selected_image'] = request('multi_selected_image');

            $this->portfoliosService->update($data);
        
        }else{

            $this->portfoliosService->create($data);
        
        }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function delete(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->portfoliosService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }
  
}