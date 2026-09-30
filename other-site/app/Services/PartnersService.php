<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Partner;
use Auth;

class PartnersService{

  use FileUpload;
  
  public function list($keyword){
    return  Partner::paginatedSearch($keyword);
  }

  public function getData($id){
    return  Partner::where('id',$id)->first();
  }

  public function getPartners($limit = null){

    $datas = Partner::whereNull('deleted_at');

    if($limit){
      $datas = $datas->limit($limit);
    }

    return $datas = $datas->get();
  }

  public function create($data){

  	$id = Partner::create([
                  					'name' => $data['name'] ?? '',
                  					'created_by' => Auth::user()->id,
                  				])->id;
  	
  	$query = Partner::where('id',$id)->first();

  	if($data['image']){
  		$query->update([
                			'image' => $this->uploadImage('client',$data['image'])
                		]);
 		}

 		return 'success';
  }

  public function update($data){

    Partner::where('id',$data['id'])
          ->update([
                      'name' => $data['name'] ?? '',
                      'updated_by' => Auth::user()->id,
                    ]);
    
    $query = Partner::where('id',$data['id'])->first();

    if($data['multi_selected_image'] == 'change'){
      $query->update([
                      'image' => $this->uploadImage('client',$data['image'])
                    ]);
    }

    return 'success';
  }

  public function delete($id){
    Partner::where('id',$id)
          ->update([
                      'deleted_at' => date('Y-m-d H:i:s'),
                      'deleted_by' => Auth::user()->id,
                  ]);

    return 'success';
  }
}     
