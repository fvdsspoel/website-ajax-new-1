<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\FileUpload;
use App\Cms;
use Auth;

class HomesService{

    use FileUpload;

    public function getCms(){

    	return Cms::whereNull('deleted_at')->first();
    }

    public function createCms($data){

    	$id = Cms::create([
	    					'home_title' => $data['home_title'] ?? '',
	    					'contact_title' => $data['contact_title'] ?? '',
	    					'about_title' => $data['about_title'] ?? '',

	    					'what_ajax' => $data['what_ajax'] ?? '',
	    					'contact_no' => $data['contact_no'] ?? '',
	    					'email' => $data['email'] ?? '',
	    					'address' => $data['address'] ?? '',
	    					'fb' => $data['fb'] ?? '',
	    					'intagram' => $data['intagram'] ?? '',
	    					'twitter' => $data['twitter'] ?? '',
	    					'yt' => $data['yt'] ?? '',
                'corporate_no' => $data['corporate_no'] ?? '',
                'corporate_email' => $data['corporate_email'] ?? '',
                'map_link' => $data['map_link'] ?? '',
	    					'about_detail' => $data['about_detail'] ?? '',
	    					'created_by' => Auth::user()->id,
	    				])->id;
    	
    	$cms = CMS::where('id',$id)->first();

    	if($data['home_banner']){
    		$cms->update([
    			'home_banner' => $this->uploadImage('cms',$data['home_banner'])
    		]);
   		}

   		if($data['contact_banner']){
    		$cms->update([
    			'contact_banner' => $this->uploadImage('cms',$data['contact_banner'])
    		]);
   		}

   		if($data['about_banner']){
    		$cms->update([
    			'about_banner' => $this->uploadImage('cms',$data['about_banner'])
    		]);
   		}

   		if($data['about_image']){
    		$cms->update([
    			'about_image' => $this->uploadImage('cms',$data['about_image'])
    		]);
   		}	

   		return 'success';
    }

    public function updateCms($data){

    	$cms =Cms::where('id',$data['id'])->first();

    	$cms->update([
    					'home_title' => $data['home_title'] ?? '',
    					'contact_title' => $data['contact_title'] ?? '',
    					'about_title' => $data['about_title'] ?? '',
    					'what_ajax' => $data['what_ajax'] ?? '',
    					'contact_no' => $data['contact_no'] ?? '',
    					'email' => $data['email'] ?? '',
    					'address' => $data['address'] ?? '',
    					'fb' => $data['fb'] ?? '',
    					'intagram' => $data['intagram'] ?? '',
    					'twitter' => $data['twitter'] ?? '',
    					'yt' => $data['yt'] ?? '',
              'corporate_no' => $data['corporate_no'] ?? '',
              'corporate_email' => $data['corporate_email'] ?? '',
              'map_link' => $data['map_link'] ?? '',
    					'about_detail' => $data['about_detail'] ?? '',
    					'created_by' => Auth::user()->id,
    				]);

    	if($data['multi_selected_home'] == 'change'){
    		$cms->update([
    			'home_banner' => $this->uploadImage('cms',$data['home_banner'])
    		]);
   		}

      if($data['multi_selected_home_mobile'] == 'change'){
        $cms->update([
          'home_mobile_banner' => $this->uploadImage('cms',$data['home_mobile_banner'])
        ]);
      }

   		if($data['multi_selected_contact'] == 'change'){
    		$cms->update([
    			'contact_banner' => $this->uploadImage('cms',$data['contact_banner'])
    		]);
   		}

      if($data['multi_selected_contact_mobile'] == 'change'){
        $cms->update([
          'contact_mobile_banner' => $this->uploadImage('cms',$data['contact_mobile_banner'])
        ]);
      }

   		if($data['multi_selected_about'] == 'change'){
    		$cms->update([
    			'about_banner' => $this->uploadImage('cms',$data['about_banner'])
    		]);
   		}

      if($data['multi_selected_about_mobile'] == 'change'){
        $cms->update([
          'about_mobile_banner' => $this->uploadImage('cms',$data['about_mobile_banner'])
        ]);
      }

   		if($data['multi_selected_aboutimage'] == 'change'){
    		$cms->update([
    			'about_image' => $this->uploadImage('cms',$data['about_image'])
    		]);
   		}	

      if($data['multi_selected_logo_image'] == 'change'){
        $cms->update([
          'logo' => $this->uploadImage('cms',$data['logo'])
        ]);
      } 

      if($data['multi_selected_icon_image'] == 'change'){
        $cms->update([
          'icon' => $this->uploadImage('cms',$data['icon'])
        ]);
      } 

   		return 'success';
    }
}     
