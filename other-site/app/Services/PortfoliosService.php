<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Portfolio;
use Auth;

class PortfoliosService{

  use FileUpload;
  
	public function list($keyword){
  	return Portfolio::paginatedSearch($keyword);
	}

  public function getData($id){
    return  Portfolio::where('id',$id)->first();
  }

  public function getPortfolios($limit = null){

    $datas = Portfolio::whereNull('deleted_at');

    if($limit){
      $datas = $datas->limit($limit);
    }

    return $datas = $datas->get();
  }

  public function create($data){

    $id = Portfolio::create([
                    'name' => $data['name'] ?? '',
                    'description' => $data['description'] ?? '',
                    'created_by' => Auth::user()->id,
                  ])->id;
  
    $query = Portfolio::where('id',$id)->first();

    if($data['image']){
      $query->update([
                      'image' => $this->uploadImage('portfolio',$data['image'])
                    ]);
    }
    return 'success';
  }

  public function update($data){

      Portfolio::where('id',$data['id'])
              ->update([
                          'name' => $data['name'] ?? '',
                          'description' => $data['description'] ?? '',
                          'updated_by' => Auth::user()->id,
                        ]);
    
      $query = Portfolio::where('id',$data['id'])->first();

      if($data['multi_selected_image'] == 'change'){
        $query->update([
                        'image' => $this->uploadImage('portfolio',$data['image'])
                      ]);
      }

      return 'success';
  }

  public function delete($id){
      Portfolio::where('id',$id)
               ->update([
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'deleted_by' => Auth::user()->id,
                        ]);

      return 'success';
  }
}     
