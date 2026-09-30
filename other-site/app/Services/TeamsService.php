<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Team;
use Auth;

class TeamsService{

  use FileUpload;
  
	public function list($keyword){
  	return  Team::paginatedSearch($keyword);
	}

	public function getData($id){
	  return  Team::where('id',$id)->first();
	}

  public function getTeams($limit = null){

    $datas = Team::whereNull('deleted_at');

    if($limit){
      $datas = $datas->limit($limit);
    }

    return $datas = $datas->get();
  }

	public function create($data){

  	$id = Team::create([
          					'name' => $data['name'] ?? '',
          					'position' => $data['position'] ?? '',
          					'created_by' => Auth::user()->id,
          				])->id;
	
		$query = Team::where('id',$id)->first();

		if($data['image']){
  		$query->update([
                			'image' => $this->uploadImage('team',$data['image'])
                		]);
		}

		return 'success';
	}

	public function update($data){

	  	Team::where('id',$data['id'])
	        ->update([
	                    'name' => $data['name'] ?? '',
	                    'position' => $data['position'] ?? '',
	                    'updated_by' => Auth::user()->id,
	                  ]);
	  
	  	$query = Team::where('id',$data['id'])->first();

	  	if($data['multi_selected_image'] == 'change'){
  	    $query->update([
  	                    'image' => $this->uploadImage('client',$data['image'])
  	                  ]);
	  	}

	  	return 'success';
	}

	public function delete($id){
	  	Team::where('id',$id)
	        ->update([
	                    'deleted_at' => date('Y-m-d H:i:s'),
	                    'deleted_by' => Auth::user()->id,
	                ]);

	  	return 'success';
	}
}     
