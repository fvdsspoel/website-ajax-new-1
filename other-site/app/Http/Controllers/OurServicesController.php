<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OurServicesService;
use Illuminate\Support\Facades\DB;

class OurServicesController extends Controller
{
  private $ourServicesService;

  public function __construct(OurServicesService $ourServicesService){

    $this->ourServicesService = $ourServicesService;
  }

  public function index(Request $request){
    $keyword = $request->keyword;
    $results = $this->ourServicesService->list($keyword);
    return view('our-services.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    return view('our-services.create',compact('data'));
  }

  public function edit($id,Request $request){
    $data = $this->ourServicesService->getData($id);
    return view('our-services.create',compact('data'));
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {

      $data = array(
                    'image' => request('image'),
                    'description' => request('description'),
                    'name' => request('name')
                );

      if(request('id')){

          $data['id'] = request('id');
          $data['multi_selected_image'] = request('multi_selected_image');

          $this->ourServicesService->update($data);
      
      }else{

          $this->ourServicesService->create($data);
      
      }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function delete(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->ourServicesService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }
}