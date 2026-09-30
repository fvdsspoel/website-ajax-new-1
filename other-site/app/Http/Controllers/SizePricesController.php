<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SizePricesService;
use Illuminate\Support\Facades\DB;

class SizePricesController extends Controller
{
  public function __construct(SizePricesService $sizePricesService){

    $this->sizePricesService = $sizePricesService;
  }

  public function index(Request $request)
  {
  	$keyword = $request->keyword;
    $results = $this->sizePricesService->list($keyword);
    return view('size-prices.index',compact('keyword','results'));
  }

  public function getData()
  {
      $data = $this->sizePricesService->getData();
      return response()->json($data);
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {
      $this->sizePricesService->store($request);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function checkData(Request $request){
    $data = $this->sizePricesService->checkData($request);
    return response()->json($data);
  }
}
