<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductsService;
use App\Services\CategoriesService;
use Illuminate\Support\Facades\DB;
use App\Helpers\ChatHelper;

class ProductsController extends Controller
{

  public function __construct(ProductsService $productsService, CategoriesService $categoriesService){

    $this->productsService = $productsService;
    $this->categoriesService = $categoriesService;
  }

  /*BE*/
  public function index(Request $request){
    $keyword = $request->keyword;
    $results = $this->productsService->list($keyword,null,null,null,null);
    return view('products.index',compact('keyword','results'));
  }

  public function create(Request $request){
    $data = null;
    $sub_categories = [];
    $categories = $this->categoriesService->getBuildableCategories();
    if(count($categories) > 0){
      $sub_categories = $this->categoriesService->getSubCategory($categories[0]->id);
    }

    return view('products.create',compact('data','categories','sub_categories'));
  }

  public function edit($id,Request $request){
      $data = $this->productsService->getData($id);
      $sub_categories = [];
      $categories = $this->categoriesService->getBuildableCategories();
      return view('products.create',compact('data','categories','sub_categories'));
  }

  public function getStyles(Request $request)
  {
      $data = $this->productsService->getStyles(request('id'));
      return response()->json($data);
  }

  public function getFeatures(Request $request)
  {
      $data = $this->productsService->getFeatures(request('id'));
      return response()->json($data);
  }

  public function getFeatureDetails(Request $request)
  {
      $data = $this->productsService->getFeatureDetails(request('product_id'),request('id'));
      return response()->json($data);
  }

  public function store(Request $request){ 
  
    $has_exceptions = DB::transaction(function() use($request) {

        if(request('id')){
          $this->productsService->update($request);
        }else{
          $this->productsService->create($request);
        }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function setting($id,Request $request){

    $product = $this->productsService->getData($id);
    $data = $this->productsService->getProductSetting($id);
    $styles = $this->productsService->getStyles($id);
    $features = $this->productsService->getFeatures($id);
    $image_combinations = $this->productsService->getCombination($id);

    if($product->active == 1){
      $image_combinations = $this->productsService->combinationWithImage($styles,$features,$image_combinations,$data->id);
    }
    
    return view('products.settings.create',compact('styles','features','image_combinations','id','data','product'));
  }

  public function settingStore(Request $request){ 

    $has_exceptions = DB::transaction(function() use($request) {
      if(request('id')){

          $this->productsService->updateSetting($request);
      }else{
          $this->productsService->createSetting($request);
      }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function getViews(Request $request)
  {
      $data = $this->productsService->getViewByStyle(request('id'));
      return response()->json($data);
  }

  public function getCustomStyleSizes(Request $request){
      $data = $this->productsService->getCustomStyleSizes(request('id'),request('style_id'));
      return response()->json($data);
  }

  public function getBasicSizes(Request $request){
      $data = $this->productsService->getBasicSizes(request('id'));
      return response()->json($data);
  }

  public function getColors(Request $request)
  {
      $data = $this->productsService->getColors(request('id'));
      return response()->json($data);
  }

  public function delete(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $this->productsService->delete($id);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  public function feature(Request $request){
    
    $has_exceptions = DB::transaction(function() use($request) {
        
        $id = request('id');
        $status = request('status');
        $this->productsService->feature($id,$status);
    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

  /*FE*/
  public function products(Request $request){

    $keyword = request('keyword') ?? null;
    $category_id = request('category_id') ?? null;
    $sub_category_id = request('sub_category_id') ?? null;

    $price_selected_min = request('price_selected_min') ?? 0;
    $price_selected_max = request('price_selected_max') ?? 0;

    $min_property_price = $this->productsService->getMinMaxProce('asc') ?? 0;
    $max_property_price = $this->productsService->getMinMaxProce('desc') ?? 500;

    if($price_selected_max == 0){
        $price_selected_min = $min_property_price;
        $price_selected_max = $max_property_price;
    }

    $categories = $this->categoriesService->getBuildableCategories();
    if(count($categories) > 0){
      $sub_categories = $this->categoriesService->getSubCategory($categories[0]->id);
    }

    $results = $this->productsService->list($keyword,$category_id,$sub_category_id,$price_selected_min,$price_selected_max,1);

    return view('front-ends.products.index',compact('categories','sub_categories','results','max_property_price','min_property_price','keyword','category_id','sub_category_id','price_selected_min','price_selected_max'));
  }

  public function show($name,$id,Request $request){
    $data = $this->productsService->getData($id);
    $images = $this->productsService->getProductPreviewImages($id);
    $user_id = ChatHelper::getChatUser();
    $convo_id = ChatHelper::getLastProductConvoId($user_id,$id);
    return view('front-ends.products.show',compact('data','images','convo_id'));
  }

  public function build($id,Request $request){

    $data = $this->productsService->getData($id);
    $product_views = $this->productsService->getViewsGroupByStyle($id);
    $basic_sizes = $this->productsService->getBasicSizes($id);
    $product_colors = $this->productsService->getColors($id);
    $features = $this->productsService->getFeatures($id);
    return view('front-ends.products.build',compact('data','product_views','basic_sizes','product_colors','features'));
  }

  public function getStyleViews(Request $request)
  { 

    $product_id = request('product_id');
    $style_id = request('style_id');
    $view_name = request('view_name');

    $data = $this->productsService->getStyleView($product_id,$style_id,$view_name);
    return response()->json($data);
  }

  public function getStyleSizes(Request $request)
  { 

    $product_id = request('product_id');
    $style_id = request('style_id');

    $data = $this->productsService->getStyleSizes($product_id,$style_id);
    return response()->json($data);
  }

  public function getSettingDetail(Request $request)
  { 
    $data = $this->productsService->getSettingDetail($request);
    return response()->json($data);
  }

  public function getProductSettingDetail(Request $request)
  { 
    $data = $this->productsService->getProductSettingDetail($request);
    return response()->json($data);
  }

  public function appointmentStore(Request $request){

    return $response = $this->productsService->appointmentStore($request);
    return response()->json($response);
  }

  public function template(Request $request){

    return $data = $this->productsService->appointmentStore($request);

    return view('front-ends.products.pdf',compact('data'));
  }

  public function productSettingsImage(Request $request){

    return $data = $this->productsService->productSettingsImage($request);
  }
}