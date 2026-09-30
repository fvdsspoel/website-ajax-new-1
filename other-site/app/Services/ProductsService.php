<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Traits\ConvertTraits;
use App\Product;
use App\ProductStyle;
use App\ProductFeature;
use App\ProductFeatureDetail;
use App\ProductView;
use App\ProductSize;
use App\ProductBasicSize;
use App\ProductColor;
use App\ProductSetting;
use App\ProductSettingDetail;
use App\ProductFeatureSetting;
use App\Appointment;
use Auth;
use PDF;
use Storage;

class ProductsService{

	use FileUpload,ConvertTraits;
	
	public function list($keyword,$category_id,$sub_category_id,$price_selected_min,$price_selected_max,$is_active = null){
  		return  Product::paginatedSearch($keyword,$category_id,$sub_category_id,$price_selected_min,$price_selected_max,$is_active);
	}

  public function getData($id){
    return  Product::where('id',$id)->first();
  }

  public function getProductSetting($id){
    return  ProductSetting::where('product_id',$id)->whereNull('deleted_at')->first();
  }

  public function getProductImages($id){
    
    $results = [];
    $data = $this->getData($id);
    
    if($data){
      $results[] = $data->image;
    }

    $setting = $this->getProductSetting($id);
    $details = $this->getProductSettingDetails($setting->id);
    foreach($details as $detail){
      $results[] = $detail->image;
    }

    return  $results;
  }

  public function getProductPreviewImages($id){
    
    $results = [];
    $data = $this->getData($id);
    
    // if($data){
    //   $results[] = $data->image;
    // }

    $setting = $this->getProductSetting($id);
    $details = $this->getProductPreviewSettingDetails($setting->id);
    foreach($details as $detail){
      $results[] = $detail->image;
    }

    return  $results;
  }

  public function getProductSettingDetails($id){
    return ProductSettingDetail::where('product_setting_id',$id)->whereNull('deleted_at')->get();
  }

  public function getProductPreviewSettingDetails($id){
    return ProductSettingDetail::where('product_setting_id',$id)->whereNull('deleted_at')->groupBy('style_id')->groupBy('view_id')->groupBy('color_id')->get();
  }

  public function getMinMaxProce($order){

    $data = Product::whereNull('deleted_at')->orderBy('price',$order)->first();
    return $data->price ?? null;
  }

  public function getStyles($id){
    return  ProductStyle::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getFeatures($id){
    return  ProductFeature::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getFeatureDetails($product_id,$id){
    return  ProductFeatureDetail::where('product_id',$product_id)->where('feature_id',$id)->whereNull('deleted_at')->orderBy('feature_id','desc')->get();
  }

  public function getFeatureDetail($id){
    return  ProductFeatureDetail::where('id',$id)->first();
  }

  public function getView($id){
    return  ProductView::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getViewByStyle($id){

    $datas = ProductView::where('product_id',$id)->whereNull('deleted_at')->orderBy('id')->get();

    return $datas;
  }

  public function getViewsGroupByStyle($id){
    return  ProductView::where('product_id',$id)->whereNull('deleted_at')->groupBy('name')->orderBy('id')->get();
  }

  public function getStyleView($product_id,$style_id,$view_name){

    $data = ProductView::where('product_id',$product_id)
                      ->where('style_id',$style_id)
                      ->where('name',$view_name)
                      ->whereNull('deleted_at')
                      ->first();
    return $data;
  }

  public function getSizes($id){
    return  ProductSize::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getStyleSizes($product_id,$style_id){
    $data = ProductSize::where('product_id',$product_id)
                      ->where('style_id',$style_id)
                      ->whereNull('deleted_at')
                      ->first();

    $arr_val[] = $data->width ?? 0;
    $arr_val[] = $data->length ?? 0;
    $arr_val[] = $data->height ?? 0;
    $arr_val[] = $data->circumference ?? 0;

    $max = max($arr_val);

    return array($data,$max);
  }

  public function getCustomStyleSizes($id,$style_id){
    return  ProductSize::with('productStyle')->where('product_id',$id)->where('style_id',$style_id)->whereNull('deleted_at')->first();
  }

  public function getBasicSizes($id){
    return  ProductBasicSize::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getColors($id){
    return  ProductColor::where('product_id',$id)->whereNull('deleted_at')->get();
  }

  public function getFeaturedList(){
    return Product::where('featured',1)->where('active',1)->get();
  }

	public function create($request){

  	$id = Product::create([
                          			'name' => request('name') ?? '',
                          			'price' =>  request('price'),
                          			'category_id' =>  request('category_id'),
                          			'sub_category_id' =>  request('sub_category_id'),
                            		'description' => request('product_detail'),
                  					    'created_by' => Auth::user()->id,
                  				])->id;
  	
  	$query = Product::where('id',$id)->first();

  	if(request('image')){
  		$query->update([
                			'image' => $this->uploadImage('products',request('image'))
                		]);
	  }

    //product colors
    for ($i=0; $i < count(request('color_name')); $i++) {

      $product_color_id = ProductColor::create([
                              'product_id' => $id,
                              'color_code' => request('color_code')[$i],
                              'name' => request('color_name')[$i],
                              'price' => request('color_price')[$i] ?? 0,
                              'description' => request('color_description')[$i],
                              'created_by' => Auth::user()->id,
                          ])->id;

      $product_color = ProductColor::where('id',$product_color_id)->first();

      if(request('multi_color')[$i]){

        $product_color->update([
                                'image' => $this->uploadImage('products',request('multi_color')[$i])
                            ]);
      }
    }

    //product style
    for ($i=0; $i < count(request('multi_style_id')) ; $i++) {

      $style_id = ProductStyle::create([
                                        'product_id' => $id,
                                        'name' => request('style_name')[$i],
                                        'description' => request('style_description')[$i],
                                        'price' => request('style_price')[$i],
                                      ])->id;

      $style_query = ProductStyle::where('id',$style_id)->first();

      if(request('multi_style')[$i]){
        $style_query->update([
                              'image' => $this->uploadImage('products',request('multi_style')[$i])
                            ]);
      }
    }

    //product size
    for ($i= 0; $i < count(request('multi_custom_size')) ; $i++) {
      $style_data = productStyle::where('name',request('custom_size_style_name')[$i])->where('product_id',$id)->whereNull('deleted_at')->first();
      $product_size_id = ProductSize::create([
                                                'product_id' => $id,
                                                'style_id' => $style_data->id,
                                                'width' =>request('custom_size_width')[$i],
                                                'created_by' => Auth::user()->id,
                                            ])->id;

      $product_size = ProductSize::where('id',$product_size_id)->first();

      if(request('multi_custom_size')[$i]){

          $product_size->update([
                                  'image' => $this->uploadImage('products',request('multi_custom_size')[$i])
                              ]);
        }
    }

    //basic size
    for ($i=0; $i < count(request('basic_size_name')); $i++) {
      ProductBasicSize::create([
                                'product_id' => $id,
                                'size' => request('basic_size_name')[$i],
                                'created_by' => Auth::user()->id,
                              ]);
    }

    //product view
    for ($i=0; $i < count(request('view_name')) ; $i++) {
      ProductView::create([
                                'product_id' => $id,
                                'name' => request('view_name')[$i],
                            ]);
    }

    //other feature
    $features = request('feature_name');
    if(isset($features)){
      for ($i=0; $i < count(request('feature_name')) ; $i++) {
        $feature_id = ProductFeature::create([
                                  'product_id' => $id,
                                  'name' => request('feature_name')[$i],
                              ])->id;
        $index = request('feature_detail_num')[$i];
        for ($a=0; $a < count(request('feature_detail_name'.$index)) ; $a++) {
          $fd_id = ProductFeatureDetail::create([
                                          'product_id' => $id,
                                          'feature_id' => $feature_id,
                                          'code' => request('feature_detail_code'.$index)[$a],
                                          'name' => request('feature_detail_name'.$index)[$a],
                                          'price' => request('feature_detail_price'.$index)[$a] ?? 0,
                                          'description' => request('feature_detail_description'.$index)[$a],
                                       ])->id;

          $fd = ProductFeatureDetail::where('id',$fd_id)->first();
          if(request('multi_feature_detail'.$index)[$a]){
            $fd->update([
                          'image' => $this->uploadImage('products',request('multi_feature_detail'.$index)[$a])
                        ]);
          }
        }
      }
    }

    return 'success';
  }

  public function update($data){

    $query = Product::where('id',request('id'))->first();

    $query->update([
                    'name' => request('name') ?? '',
                    'price' =>  request('price'),
                    'category_id' =>  request('category_id'),
                    'sub_category_id' =>  request('sub_category_id'),
                    'description' => request('product_detail'),
                    'updated_by' => Auth::user()->id,
                  ]);

    if(request('multi_selected_image') == 'change'){

      $query->update([
                      'image' => $this->uploadImage('products',request('image'))
                    ]);
    }

    //product colors
    ProductColor::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($i=0; $i < count(request('color_name')); $i++) {

      $color_check = ProductColor::where('id',request('color_id')[$i])->first();
      if($color_check){
        $color_check->update([
                                'color_code' => request('color_code')[$i],
                                'name' => request('color_name')[$i],
                                'price' => request('color_price')[$i] ?? 0,
                                'description' => request('color_description')[$i],
                                'updated_by' => Auth::user()->id,
                                'deleted_at' => null,
                                'deleted_by' => null
                             ]);
        $product_color_id = request('color_id')[$i];
      }else{
        $product_color_id = ProductColor::create([
                                'product_id' => request('id'),
                                'color_code' => request('color_code')[$i],
                                'name' => request('color_name')[$i],
                                'price' => request('color_price')[$i] ?? 0,
                                'description' => request('color_description')[$i],
                                'created_by' => Auth::user()->id,
                            ])->id;
      }

      $product_color = ProductColor::where('id',$product_color_id)->first();

      if(request('multi_color_selected_id')[$i] == 'change'){

        $product_color->update([
                                'image' => $this->uploadImage('products',request('multi_color')[$i])
                            ]);
      }
    }

    //product style
    ProductStyle::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($a=0; $a < count(request('style_name')); $a++) {

      $style_check = ProductStyle::where('id',request('style_id')[$a])->first();
      if($style_check){
        $style_check->update([
                                'name' => request('style_name')[$a],
                                'price' => request('style_price')[$a] ?? 0,
                                'description' => request('style_description')[$a],
                                'updated_by' => Auth::user()->id,
                                'deleted_at' => null,
                                'deleted_by' => null
                             ]);
        $product_style_id = request('style_id')[$a];
      }else{
        $product_style_id = ProductStyle::create([
                                'product_id' => request('id'),
                                'name' => request('style_name')[$a],
                                'price' => request('style_price')[$a] ?? 0,
                                'description' => request('style_description')[$a],
                                'created_by' => Auth::user()->id,
                            ])->id;
      }

      $product_style = ProductStyle::where('id',$product_style_id)->first();

      if(request('multi_style_id')[$a] == 'change'){

        $product_style->update([
                                'image' => $this->uploadImage('products',request('multi_style')[$a])
                            ]);
      }
    }

    //product custom size
    ProductSize::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($b=0; $b < count(request('custom_size_width')); $b++) {

      $custom_size_check = ProductSize::where('id',request('custom_size_id')[$b])->first();
      if($custom_size_check){
        $custom_size_check->update([
                                'style_id' => request('custom_style_id')[$b],
                                'width' => request('custom_size_width')[$b] ?? 0,
                                'updated_by' => Auth::user()->id,
                                'deleted_at' => null,
                                'deleted_by' => null
                             ]);
        $product_custom_size_id = request('custom_size_id')[$b];
      }else{
        $style_data = productStyle::where('name',request('custom_size_style_name')[$b])->whereNull('deleted_at')->first();
        $product_custom_size_id = ProductSize::create([
                                'product_id' => request('id'),
                                'style_id' => $style_data->id,
                                'width' => request('custom_size_width')[$b] ?? 0,
                                'created_by' => Auth::user()->id,
                            ])->id;
      }

      $product_custom_size = ProductSize::where('id',$product_custom_size_id)->first();

      if(request('multi_custome_size_id')[$b] == 'change'){

        $product_custom_size->update([
                                'image' => $this->uploadImage('products',request('multi_custom_size')[$b])
                            ]);
      }
    }

    //basic size
    ProductBasicSize::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($b=0; $b < count(request('basic_size_name')); $b++) {

      $basic_size_check = ProductBasicSize::where('id',request('basic_size_id')[$b])->first();
      if($basic_size_check){
        $basic_size_check->update([
                                'size' => request('basic_size_name')[$b],
                                'updated_by' => Auth::user()->id,
                                'deleted_at' => null,
                                'deleted_by' => null
                             ]);
        $product_basic_size_id = request('basic_size_id')[$b];
      }else{
        $product_basic_size_id = ProductBasicSize::create([
                                'product_id' => request('id'),
                                'size' => request('basic_size_name')[$b] ?? 0,
                                'created_by' => Auth::user()->id,
                            ])->id;
      }
    }

    //product view
    ProductView::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($b=0; $b < count(request('view_name')); $b++) {

      $view_check = ProductView::where('id',request('view_id')[$b])->first();
      if($view_check){
        $view_check->update([
                              'name' => request('view_name')[$b],
                              'updated_by' => Auth::user()->id,
                              'deleted_at' => null,
                              'deleted_by' => null
                           ]);
        $product_view_id = request('view_id')[$b];
      }else{
        $product_view_id = ProductView::create([
                                'product_id' => request('id'),
                                'name' => request('view_name')[$b],
                                'created_by' => Auth::user()->id,
                            ])->id;
      }
    }

    //product features
    ProductFeature::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
    for ($b=0; $b < count(request('feature_name')); $b++) {

      $features_check = ProductFeature::where('id',request('feature_id')[$b])->first();
      $index = request('feature_detail_num')[$b];
      if($features_check){
        $features_check->update([
                              'name' => request('feature_name')[$b],
                              'updated_by' => Auth::user()->id,
                              'deleted_at' => null,
                              'deleted_by' => null
                           ]);
        $product_feature_id = request('feature_id')[$b];
        ProductFeatureDetail::where('feature_id',$product_feature_id)->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);
        for ($a=0; $a < count(request('feature_detail_name'.$index)) ; $a++) {
          
          $feature_detail_check = ProductFeatureDetail::where('id',request('feature_detail_id'.$index)[$a])->first();
          
          if($feature_detail_check){
            $feature_detail_check->update([
                                              'name' => request('feature_detail_name'.$index)[$a],
                                              'code' => request('feature_detail_code'.$index)[$a],
                                              'price' => request('feature_detail_price'.$index)[$a] ?? 0,
                                              'description' => request('feature_detail_description'.$index)[$a],
                                              'deleted_at' => null,
                                              'deleted_by' => null
                                          ]);
            $fd_id = request('feature_detail_id'.$index)[$a];
          }else{
            $fd_id = ProductFeatureDetail::create([
                                            'product_id' => request('id'),
                                            'feature_id' => $product_feature_id,
                                            'name' => request('feature_detail_name'.$index)[$a],
                                            'code' => request('feature_detail_code'.$index)[$a],
                                            'price' => request('feature_detail_price'.$index)[$a] ?? 0,
                                            'description' => request('feature_detail_description'.$index)[$a],
                                         ])->id;
          }

          $fd = ProductFeatureDetail::where('id',$fd_id)->first();
          if(request('multi_feature_detail_selected_id'.$index)[$a] == 'change'){
            $fd->update([
                          'image' => $this->uploadImage('products',request('multi_feature_detail'.$index)[$a])
                        ]);
          }

        }

      }else{
        $product_feature_id = ProductFeature::create([
                                'product_id' => request('id'),
                                'name' => request('feature_name')[$b],
                                'created_by' => Auth::user()->id,
                            ])->id;
        for ($a=0; $a < count(request('feature_detail_name'.$index)) ; $a++) {
          $fd_id = ProductFeatureDetail::create([
                                          'product_id' => request('id'),
                                          'feature_id' => $product_feature_id,
                                          'name' => request('feature_detail_name'.$index)[$a],
                                          'code' => request('feature_detail_code'.$index)[$a],
                                          'price' => request('feature_detail_price'.$index)[$a] ?? 0,
                                          'description' => request('feature_detail_description'.$index)[$a],
                                       ])->id;

          $fd = ProductFeatureDetail::where('id',$fd_id)->first();
          if(request('multi_feature_detail'.$index)[$a]){
            $fd->update([
                          'image' => $this->uploadImage('products',request('multi_feature_detail'.$index)[$a])
                        ]);
          }
        }
      }
    }
    
    Product::where('id',request('id'))->update(['active' => 0]);
    ProductSetting::where('product_id',request('id'))->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);

    return 'success';
  }

  public function getCombination($id){

    $datas = [];
    $image_combinations = [];

    $styles = $this->getStyles($id);
    $views = $this->getView($id);
    $colors = $this->getColors($id);
    $features = $this->getFeatures($id);

    
    $datas['view_name'] = $this->dataArrayManipulation($views,'name');
    $datas['color_name'] = $this->dataArrayManipulation($colors,'name');
    
    foreach ($features as $key => $feature) {
      $details = $this->getFeatureDetails($id,$feature->id);
      $datas['feature_name_'.$key] = $this->dataArrayManipulation($details,'name');
    }

    $combinations = $this->get_combinations($datas);
    
    foreach ($combinations as $combination) {
      $image_combinations[] = $this->getIdCombinations($combination,$id,$features);
    }

    return $image_combinations;
  }

  public function combinationWithImage($styles,$features,$datas,$id){

    $results = [];
    foreach ($styles as $style) {
      $result_arr = [];
      foreach ($datas as $data) {

        $f_ids = null;
        $fd_ids = null;
        foreach ($features as $key => $feature) {
          $f_ids = $f_ids . ',' . $feature->id;
          $fd_ids = $fd_ids . ',' . $data['feature_id_'.$key];
        }
        $value = ProductSettingDetail::where('product_setting_id',$id)
                                    ->where('style_id',$style->id)
                                    ->where('view_id',$data['view_id'])
                                    ->where('color_id',$data['color_id'])
                                    ->where('feature_id',$f_ids)
                                    ->where('feature_detail_id',$fd_ids)
                                    ->first();

        $val = array(
                            "view_name" => $data['view_name'],
                            "color_name" => $data['color_name'],

                            "view_id" => $data['view_id'],
                            "color_id" => $data['color_id'],
                            'image' => $value->image ?? '',
                            'style_id' => $style->id,
                            'product_setting_id' => $value->id ?? ''
                          );
        foreach ($features as $k => $feature) {
          $val['feature_name_'.$k] = $data['feature_name_'.$k];
          $val['feature_id_'.$k] = $data['feature_id_'.$k];
        }

        $result_arr[] = $val;
      }
      $results[] = $result_arr;
    }
    return $results;
  }

  public function createSetting($request){
    $setting_id = ProductSetting::create([
                              'product_id' => request('product_id'),
                              'created_by' => Auth::user()->id,
                           ])->id;
    for ($i=0; $i < count(request('style_id')); $i++) {
      
      for($a=0; $a < count(request('view_id_'.$i)); $a++){
        if(request('multi_image_setting_'.$i)[$a] == 'change'){
          $image = $this->uploadImage('products',request('image_'.$i)[$a]);
        }else{
          $image = '/storage/products/76JAp9yAaRPtuDpyHSfsXZ6QqfyC5Cq1kNeORPGu.webp';
        }

        $id = ProductSettingDetail::create([
                                  'product_setting_id' => $setting_id,
                                  'style_id'           => request('style_id')[$i],
                                  'view_id'            => request('view_id_'.$i)[$a],
                                  'color_id'           => request('color_id_'.$i)[$a],
                                  'image'              => $image,
                                  'created_by'         => Auth::user()->id,
                               ])->id;

        $f_ids = null;
        $fd_ids = null;

        for($b=0; $b < (int)request('feature_count'); $b++){
          
          ProductFeatureSetting::create([
                                            'product_setting_detail_id' => $id,
                                            'feature_id'         => request('feature_id_'.$i.$a)[$b],
                                            'feature_detail_id'  => request('feature_detail_id_'.$i.$a)[$b],
                                        ]);
          $f_ids = $f_ids . ',' . request('feature_id_'.$i.$a)[$b];
          $fd_ids = $fd_ids . ',' . request('feature_detail_id_'.$i.$a)[$b];
        }

        ProductSettingDetail::where('id',$id)->update(['feature_id' => $f_ids, 'feature_detail_id' => $fd_ids]);
      }
    }
    Product::where('id',request('product_id'))->update(['active' => 1]);
    return 'success';
  }

  public function updateSetting($request){
    
    for ($i=0; $i < count(request('style_id')); $i++) { 
      for($a=0; $a < count(request('view_id_'.$i)); $a++){
        
        if(request('multi_image_setting_'.$i)[$a] == 'change'){

          $image = $this->uploadImage('products',request('image_'.$i)[$a]);

          ProductSettingDetail::where('id',request('product_setting_id_'.$i)[$a])->update(['image' => $image]);
        }

      }
    }

    Product::where('id',request('product_id'))->update(['active' => 1]);
    
    return 'success';
  }

  public function delete($id){
    Product::where('id',$id)
          ->update([
                      'deleted_at' => date('Y-m-d H:i:s'),
                      'deleted_by' => Auth::user()->id,
                  ]);

    return 'success';
  }

  public function feature($id,$status){
    Product::where('id',$id)
          ->update([
                      'featured' => $status,
                  ]);

    return 'success';
  }

  public function getIdCombinations($data,$product_id,$features){
    
    //view
    $view_id = ProductView::where('name',$data['view_name'])->where('product_id',$product_id)->first();
    $data['view_id'] = $view_id->id ?? 0;
    
    //color
    $color_id = ProductColor::where('name',$data['color_name'])->where('product_id',$product_id)->first();
    $data['color_id'] = $color_id->id ?? 0;

    //features
    foreach ($features as $key => $feature) {
      $feature_id = ProductFeatureDetail::where('name',$data['feature_name_'.$key])->where('product_id',$product_id)->where('feature_id',$feature->id)->first();
      $data['feature_id_'.$key] = $feature_id->id ?? 0;
    }
    return $data;
  }

  public function getSettingDetail($request){

    $data = ProductSetting::where('product_id',request('product_id'))->whereNull('deleted_at')->first();
    return ProductSettingDetail::where('product_setting_id',$data->id)
                              ->where('style_id',request('style_id'))
                              ->where('view_id',request('view_id'))
                              ->where('color_id',request('color_id'))
                              ->where('feature_id',request('feature_id'))
                              ->where('feature_detail_id',request('feature_detail_id'))
                              ->whereNull('deleted_at')
                              ->first();

  }

  public function getProductSettingDetail($request){

    $style = ProductStyle::where('id',request('style_id'))->whereNull('deleted_at')->first();
    $color = ProductColor::where('id',request('color_id'))->whereNull('deleted_at')->first();

    $val =  array(
                  'style_id' => $style->id,
                  'style_name' => $style->name,
                  'style_price' => $style->price,

                  'color_id' => $color->id,
                  'color_name' => $color->name,
                  'color_code' => $color->color_code,
                  'color_price' => $color->price,
                );

    if(request('size_type') == 'basic_size'){
      $sizes = ProductBasicSize::where('id',request('size_id'))->whereNull('deleted_at')->first();
      $val['size_id'] = $sizes->id;
      $val['size_name'] = $sizes->size;
    }

    for($i = 0; $i < count(request('feature_detail_id')); $i++){

      $detail = ProductFeatureDetail::where('id',request('feature_detail_id')[$i])->whereNull('deleted_at')->first();
      
      $val['feature_detail_id_'.$detail->productFeature->id] = $detail->id;
      $val['feature_detail_'.$detail->productFeature->id] = $detail->name;
      $val['feature_detail_code_'.$detail->productFeature->id] = $detail->code;
      $val['feature_detail_price_'.$detail->productFeature->id] = $detail->price;
    }

    return $val;
  }

  public function appointmentStore($request){

    $features = $this->getFeatures(request('summary_id'));
    $f_ids = null;
    $fd_ids = null;

    foreach ($features as $key => $feature) {
      $f_ids = $f_ids . ',' . request('summary_fid_'.$feature->id);
      $fd_ids = $fd_ids . ',' . request('summary_feature_id_'.$feature->id);
    }

    $check = Appointment::where('email',request('email'))
                        ->where('product_id',request('summary_id'))
                        ->where('style_id',request('summary_style_id'))
                        ->where('layout_design',request('summary_layout_design'))
                        ->where('size_type',request('summary_size_type'))
                        ->where('size',request('summary_size'))
                        ->where('size_id',request('summary_size_id'))
                        ->where('size_price',request('summary_size_price'))
                        ->where('color_id',request('summary_color_id'))
                        ->where('feature_id',$f_ids)
                        ->where('feature_detail_id',$fd_ids)
                        ->where('final_price',request('summary_total_price'))
                        ->first();

    if($check){
      $check->update([
                        'email'             => request('email'),
                        'first_name'        => request('first_name'),
                        'last_name'         => request('last_name'),
                        'phone_no'          => request('phone'),
                        'appointment_date'  => request('appointment_date'),
                        'appointment_time'  => request('appointment_time'),
                        'remarks'           => request('remarks'),
                     ]);
      $id = $check->id;
    }else{
      $id = Appointment::create([
                              'product_id'        => request('summary_id'),
                              'style_id'          => request('summary_style_id'),
                              'layout_design'     => request('summary_layout_design'),
                              'size_type'         => request('summary_size_type'),
                              'size'              => request('summary_size'),
                              'size_id'           => request('summary_size_id'),
                              'size_price'        => request('summary_size_price'),
                              'color_id'          => request('summary_color_id'),
                              'feature_id'        => $f_ids,
                              'feature_detail_id' => $fd_ids,
                              'final_price'       => request('summary_total_price'),
                              'email'             => request('email'),
                              'first_name'        => request('first_name'),
                              'last_name'         => request('last_name'),
                              'phone_no'          => request('phone'),
                              'appointment_date'  => request('appointment_date'),
                              'appointment_time'  => request('appointment_time'),
                              'remarks'           => request('remarks'),
                          ])->id;
    }

    $appointment = Appointment::where('id',$id)->first();
    $features = ProductFeature::where('product_id',$appointment->product_id)->whereNull('deleted_at')->get();
    //generate pdf
    $date = $appointment->appointment_date .' '. $appointment->appointment_time;
    $data = [
              'order_number'      => $appointment->order_number ?? '',
              'customer_name'     => $appointment->first_name . ' ' . $appointment->last_name,
              'phone_no'          => $appointment->phone_no,
              'email'             => $appointment->email,
              'date'              => date("M j, Y g:ia", strtotime($date)),

              'product_name'      => $appointment->product->name ?? '',
              'product_price'     => number_format($appointment->product->price,2) ?? 0,
              'style_name'        => $appointment->productStyle->name ?? '',
              'style_price'       => number_format($appointment->productStyle->price,2) ?? 0,
              'layout_design'     => $appointment->layout_design ?? '',
              'size_name'         => $appointment->size ?? '',
              'size_price'        => number_format($appointment->size_price,2) ?? 0,
              'color'             => $appointment->productColor->name ?? '',
              'color_code'        => $appointment->productColor->color_code ?? '',
              'color_price'       => number_format($appointment->productColor->price,2) ?? 0,
              'final_price'       => number_format($appointment->final_price,2) ?? 0,
              'feature_count'     => count($features),
              'remarks'           => $appointment->remarks,
            ];

    $feature_arr = explode(",",$appointment->feature_detail_id);
    for($i=0; $i < count($feature_arr); $i++){
      
      $detail = ProductFeatureDetail::where('id',$feature_arr[$i])->first();
        $data['feature_name_'.$i] = $detail->productFeature->name ?? 'none';
        $data['feature_detail_name'.$i] = $detail->name ?? '';
        $data['feature_detail_code'.$i] = $detail->code ?? '';
        $data['feature_detail_price'.$i] = number_format($detail->price ?? 0,2);
    }

    // return $data;
    $pdf = PDF::loadView('front-ends.products.pdf', ['data' => $data]);
    $content = $pdf->download()->getOriginalContent();
    Storage::put('public/product-pdf/appointment-'.$id.'.pdf',$content);
    $path='/storage/product-pdf/appointment-'.$id.'.pdf';  

    $appointment->update(['link' => $path]);

    return array('success',$path);
  }

  public function productSettingsImage($request){

    $datas =  ProductSettingDetail::where('product_setting_id',request('id'))->where('style_id',request('syle'))->whereNull('deleted_at')->whereNull('deleted_by')->orderBy('id')->get();

    foreach ($datas as $key => $data) {
      $link = '/assets/images/products/'.request('product_name').'/'.request('folder_name').'/'.request('sub_folder').'/' . ($key + 1) . '.webp';
      $data->update(['image' => $link]);
    }

    return 'success';
  }
}     
