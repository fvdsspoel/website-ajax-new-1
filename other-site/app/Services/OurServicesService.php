<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\OurService ;
use Auth;

class OurServicesService{

  use FileUpload;
  
  public function list($keyword){
    return  OurService::paginatedSearch($keyword);
  }

  public function getData($id){
    return  OurService::where('id',$id)->first();
  }

  public function getServices($limit = null){

    $datas = OurService::whereNull('deleted_at');

    if($limit){
      $datas = $datas->limit($limit);
    }

    return $datas = $datas->get();
  }

  public function create($data){

    $id = OurService::create([
                    'name' => $data['name'] ?? '',
                    'description' => $data['description'] ?? '',
                    'created_by' => Auth::user()->id,
                  ])->id;
  
    $query = OurService::where('id',$id)->first();

    if($data['image']){
      $query->update([
                      'image' => $this->uploadImage('our-services',$data['image'])
                    ]);
    }

    return 'success';
  }

  public function update($data){

      OurService::where('id',$data['id'])
              ->update([
                          'name' => $data['name'] ?? '',
                          'description' => $data['description'] ?? '',
                          'updated_by' => Auth::user()->id,
                        ]);
    
      $query = OurService::where('id',$data['id'])->first();

      if($data['multi_selected_image'] == 'change'){
        $query->update([
                        'image' => $this->uploadImage('client',$data['image'])
                      ]);
      }

      return 'success';
  }

  public function delete($id){
    
      OurService::where('id',$id)
              ->update([
                          'deleted_at' => date('Y-m-d H:i:s'),
                          'deleted_by' => Auth::user()->id,
                      ]);

      return 'success';
  }
}     
