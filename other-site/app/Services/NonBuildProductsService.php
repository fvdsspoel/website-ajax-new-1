<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Traits\ConvertTraits;
use App\NonBuildProduct;
use App\NonBuildSubProduct;
use Auth;
use PDF;
use Storage;

class NonBuildProductsService{
  
  	use FileUpload,ConvertTraits;
	
	public function list($keyword){
  		return NonBuildProduct::paginatedSearch($keyword);
	}

	public function getData($id){
  	return NonBuildProduct::where('id',$id)->first();
	}

  public function getDatas($category_id){
    return NonBuildProduct::where('category_id',$category_id)->whereNull('deleted_at')->whereNull('deleted_by')->get();
  }

  public function getSubDatas($id,$category_id,$keyword){
    
    if($id){
      $datas = NonBuildSubProduct::paginatedSearch($keyword,$id);
    }else{
      $product = NonBuildProduct::where('category_id',$category_id)->whereNull('deleted_at')->whereNull('deleted_by')->first();
      $datas = NonBuildSubProduct::paginatedSearch($keyword,$product->id ?? '');
    }

    return $datas;
  }

  public function getSubData($id){
      return NonBuildSubProduct::where('id',$id)->first();
    }

	public function getSubProducts($product_id){
  	return NonBuildSubProduct::where('product_id',$product_id)->whereNull('deleted_at')->get();
	}

	public function create($request){

	  $id = NonBuildProduct::create([
		  	                  'name' => request('category_name') ?? '',
		  	                  'category_id' => request('category_id') ?? '',
		  	                  'created_by' => Auth::user()->id,
		  	                ])->id;
	
	  $query = NonBuildProduct::where('id',$id)->first();

	  if(request('image')){
	    $query->update([
	                    'image' => $this->uploadImage('products',request('image'))
	                  ]);
	  }

	  if(request('image_mobile')){
	    $query->update([
	                    'image_mobile' => $this->uploadImage('products',request('image_mobile'))
	                  ]);
	  }

	  $product = request('product_price');
	  if(isset($product)){
	  	for ($i=0; $i < count(request('product_price')) ; $i++) {

	  		$product_id = NonBuildSubProduct::create([
		  		                                  'product_id' => $id,
		  		                                  'name' => request('product_name')[$i],
		  		                                  'price' => request('product_price')[$i],
		  		                                  'description' => request('product_description')[$i],
		  		                                  // 'link' => request('product_link')[$i],
		  		                                  'created_by' => Auth::user()->id,
		  		                              ])->id;

	  		$product_query = NonBuildSubProduct::where('id',$product_id)->first();

	  		if(request('multi_selected')[$i]){
	  		  	$product_query->update([
	  		                      		'image' => $this->uploadImage('products',request('multi_selected')[$i])
	  		                       ]);
	  		}
	  	}
	  }

	  return 'success';
	}

	public function update($data){

    NonBuildProduct::where('id',request('id'))
            ->update([
                        'name' => request('category_name') ?? '',
                        'category_id' => request('category_id') ?? '',
                        'updated_by' => Auth::user()->id,
                      ]);
  
    $query = NonBuildProduct::where('id',request('id'))->first();

    if(request('multi_selected_image') == 'change'){
      $query->update([
                      'image' => $this->uploadImage('products',request('image'))
                    ]);
    }

    if(request('multi_selected_image_mobile') == 'change'){
      $query->update([
                      'image_mobile' => $this->uploadImage('products',request('image_mobile'))
                    ]);
    }

    NonBuildSubProduct::where('product_id',request('id'))
    	   ->update([
    	             	'deleted_at' => date('Y-m-d H:i:s'),
    	             	'deleted_by' => Auth::user()->id,
    	         	]);

   	$product = request('product_price');
   	if(isset($product)){
   	  	for ($i=0; $i < count(request('product_price')) ; $i++) {

   	  		$check = NonBuildSubProduct::where('id',request('product_id')[$i])->first();
   	  		if($check){

   	  			$check->update([
   	  								'name' => request('product_name')[$i],
   	  								'price' => request('product_price')[$i],
   	  								'description' => request('product_description')[$i],
   	  								// 'link' => request('product_link')[$i],
   	  								'deleted_at' => null,
   	  								'deleted_by' => null,
   	  								'updated_by' => Auth::user()->id,
   	  						   ]);
   	  		}else{

			  		$product_id = NonBuildSubProduct::create([
				  		                                  'product_id' => request('id'),
				  		                                  'name' => request('product_name')[$i],
				  		                                  'price' => request('product_price')[$i],
				  		                                  'description' => request('product_description')[$i],
				  		                                  'created_by' => Auth::user()->id,
				  		                              ])->id;
			  		$check = NonBuildSubProduct::where('id',$product_id)->first();
   	  		}
   	  		

   	  		if(request('multi_selected_id')[$i] == 'change'){
   	  		  	$check->update([
 	  		                      		'image' => $this->uploadImage('products',request('multi_selected')[$i])
 	  		                       ]);
   	  		}
   	  	}
   	}

    return 'success';
  }

  public function delete($id){
    NonBuildProduct::where('id',$id)
         		->update([
                    	'deleted_at' => date('Y-m-d H:i:s'),
                    	'deleted_by' => Auth::user()->id,
                	]);

  	return 'success';
	}
}     
