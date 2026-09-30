<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\SizePrice;
use Auth;

class SizePricesService{

  public function list($keyword){
    return  SizePrice::paginatedSearch($keyword);
  }

  public function getData(){
    return  SizePrice::whereNull('deleted_at')->get();
  }

  public function store($request){

  	SizePrice::whereNull('deleted_at')->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => request('current_user')]);
  	for ($i=0; $i < count(request('size_price')) ; $i++) {

	  	$check = SizePrice::where('id',request('size_price_id')[$i])->first();
	  	if($check){
	  		$check->update([
	  							'min_size'	 => request('min_size')[$i],
	  							'max_size'	 => request('max_size')[$i],
	  							'price'		 => request('size_price')[$i],
	  							'updated_by' => request('current_user'),
	  							'deleted_at' => null,
	  							'deleted_by' => null
	  					   ]);
	  	}else{
	  		SizePrice::create([
	  							'min_size'	 => request('min_size')[$i],
	  							'max_size'	 => request('max_size')[$i],
	  							'price'		 => request('size_price')[$i],
	  							'created_by' => request('current_user'),
	  						  ]);
	  	}
	}

  	return 'success';
  }

  public function checkData($request){

    $check = null;
  	$size = (int)request('size');
  	$max = SizePrice::whereNull('max_size')->whereNull('deleted_at')->first();
  	if($max){
  		$check = SizePrice::where('min_size','<=',$size)->where('id',$max->id)->whereNull('deleted_at')->first();
  	}

  	if(!$check){
  		$check = SizePrice::where('min_size','<=',$size)->where('max_size','>=',$size)->whereNull('deleted_at')->first();
  	}
  	
  	return $check;
  }
}     
