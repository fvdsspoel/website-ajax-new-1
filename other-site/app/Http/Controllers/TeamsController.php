<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamsService;
use Illuminate\Support\Facades\DB;

class TeamsController extends Controller
{
  private $teamsService;

  public function __construct(TeamsService $teamsService){

    $this->teamsService = $teamsService;
  }

  public function index(Request $request){
  	$keyword = $request->keyword;
    $results = $this->teamsService->list($keyword);
    return view('teams.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    return view('teams.create',compact('data'));
  }

  public function edit($id,Request $request){
    $data = $this->teamsService->getData($id);
    return view('teams.create',compact('data'));
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {

        $data = array(
                      'image' => request('image'),
                      'position' => request('position'),
                      'name' => request('name'),
                  );

        if(request('id')){

            $data['id'] = request('id');
            $data['multi_selected_image'] = request('multi_selected_image');

            $this->teamsService->update($data);
        
        }else{

            $this->teamsService->create($data);
        
        }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function delete(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->teamsService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

}