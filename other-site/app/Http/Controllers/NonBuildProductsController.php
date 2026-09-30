<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NonBuildProductsService;
use App\Services\CategoriesService;
use Illuminate\Support\Facades\DB;
use App\Helpers\ChatHelper;

class NonBuildProductsController extends Controller
{

  public function __construct(NonBuildProductsService $nonBuildProductsService,CategoriesService $categoriesService){
    $this->nonBuildProductsService = $nonBuildProductsService;
    $this->categoriesService = $categoriesService;
  }

  /*FE*/
  public function list($category_id){  
    $product_id = request('product_id') ?? null;
    $keyword = request('keyword') ?? '';
    $category = $this->categoriesService->getData($category_id);
    $products =$this->nonBuildProductsService->getDatas($category_id);
    $results = $this->nonBuildProductsService->getSubDatas($product_id,$category_id,$keyword);
    return view('front-ends.non-build-products.index',compact('category','results','product_id','keyword','products'));
  }

  public function show($name,$id){
    $data = $this->nonBuildProductsService->getSubData($id);
    $user_id = ChatHelper::getChatUser();
    $convo_id = ChatHelper::getLastProductConvoId($user_id,$id,'non_build_product_id');
    return view('front-ends.non-build-products.show',compact('data','convo_id'));
  }

  /*BE*/
  public function index(Request $request){
    $keyword = $request->keyword;
    $results = $this->nonBuildProductsService->list($keyword);
    return view('non-build-products.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    $categories = $this->categoriesService->getNonBuildableCategories();
    return view('non-build-products.create',compact('data','categories'));
  }

  public function edit($id,Request $request){
      $data = $this->nonBuildProductsService->getData($id);
      $categories = $this->categoriesService->getNonBuildableCategories();
      return view('non-build-products.create',compact('data','categories'));
    }

  public function store(Request $request){ 
    
    $has_exceptions = DB::transaction(function() use($request) {

        if(request('id')){
          $this->nonBuildProductsService->update($request);
        }else{
          $this->nonBuildProductsService->create($request);
        }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function getSubProducts(Request $request){
    $id = request('id');
    $datas = $this->nonBuildProductsService->getSubProducts($id);
    return response()->json($datas);
  }

  public function delete(Request $request){
      
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->nonBuildProductsService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }
}