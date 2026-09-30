<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Category ;
use App\SubCategory;
use Auth;

class CategoriesService{

  use FileUpload;
  
  public function list($keyword){
    return  Category::paginatedSearch($keyword);
  }

  public function getData($id){
    return  Category::where('id',$id)->first();
  }

  public function getCategories(){
    return Category::whereNull('deleted_at')->whereNull('deleted_at')->get();
  }

  public function getBuildableCategories(){
    return Category::whereNull('deleted_at')->whereNull('deleted_at')->where('category_type','Buildable')->get();
  }

  public function getNonBuildableCategories(){
    return Category::whereNull('deleted_at')->whereNull('deleted_at')->where('category_type','Non Buildable')->get();
  }

  public function getSubCategory($id){
    return SubCategory::where('category_id',$id)->whereNull('deleted_at')->get();
  }

  public function create($data){

  	$id = Category::create([
                  					'name' => $data['name'] ?? '',
                            'description' => $data['description'],
                            'category_type' => $data['category_type'],
                  					'created_by' => Auth::user()->id,
                  				])->id;
  	
  	$query = Category::where('id',$id)->first();

  	if($data['image']){
  		$query->update([
                			'image' => $this->uploadImage('category',$data['image'])
                		]);
 		}

    if(isset($data['multi_selected_id'])){
      for ($i=0; $i < count(request('multi_selected_id')) ; $i++) {

        $sub_id = SubCategory::create([
                                          'category_id' => $id,
                                          'name' => $data['sub_category'][$i]
                                      ])->id;

        $sub_query = SubCategory::where('id',$sub_id)->first();

        if($data['multi_selected'][$i]){
          $sub_query->update([
                              'image' => $this->uploadImage('category',$data['multi_selected'][$i])
                            ]);
        }
      }
    }

 		return 'success';
  }

  public function update($data){

    $query = Category::where('id',$data['id'])->first();

    $query->update([
              'name' => $data['name'] ?? '',
              'description' => $data['description'],
              'category_type' => $data['category_type'],
              'updated_by' => Auth::user()->id,
            ]);

    if($data['multi_selected_image'] == 'change'){

      $query->update([
                      'image' => $this->uploadImage('category',$data['image'])
                    ]);
    }

    SubCategory::where('category_id',$data['id'])
              ->update([
                          'deleted_at' => date('Y-m-d H:i:s')
                      ]);
    if(isset($data['multi_selected_id'])){
      for ($i=0; $i < count($data['multi_selected_id']); $i++) {
        
        SubCategory::where('id',$data['sub_category_id'][$i])
                  ->update([
                            'name' => $data['sub_category'][$i],
                            'deleted_at' => null
                          ]);


        if($data['multi_selected_id'][$i] == 'change'){
          SubCategory::where('id',$data['sub_category_id'][$i])
                    ->update([
                              'image' => $this->uploadImage('category',$data['multi_selected'][$i])
                            ]);
        } 
      }
    }

    return 'success';
  }

  public function delete($id){
    Category::where('id',$id)
            ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => Auth::user()->id,
                    ]);

    return 'success';
  }
}     
