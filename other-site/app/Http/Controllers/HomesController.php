<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomesService;
use App\Services\CategoriesService;
use App\Services\PartnersService;
use App\Services\ProductsService;
use Illuminate\Support\Facades\DB;

class HomesController extends Controller
{
  private $homesService,$categoriesService,$partnersService,$productsService;

  public function __construct(HomesService $homesService, CategoriesService $categoriesService, PartnersService $partnersService,ProductsService $productsService){

    $this->homesService = $homesService;
    $this->categoriesService = $categoriesService;
    $this->partnersService = $partnersService;
    $this->productsService = $productsService;
  }
   
  public function index()
  { 
    $categories = $this->categoriesService->getCategories();
    $partners = $this->partnersService->getPartners(6);
    $featureds = $this->productsService->getFeaturedList();
    return view('front-ends.homes.index',compact('categories','partners','featureds'));
  }

  public function dashboard()
  {	
    $data = $this->homesService->getCms();
    return view('homes.index',compact('data'));
  }

  public function cmsStore(Request $request)
  {	
    $has_exceptions = DB::transaction(function() use($request) {

      $data = array(
                      'home_title' => request('home_title'),
                      'contact_title' => request('contact_title'),
                      'about_title' => request('about_title'),
                      'what_ajax' => request('what_ajax'),
                      'contact_no' => request('contact_no'),
                      'email' => request('email'),
                      'address' => request('address'),
                      'fb' => request('fb'),
                      'intagram' => request('intagram'),
                      'twitter' => request('twitter'),
                      'yt' => request('yt'),
                      'corporate_no' => request('corporate_no'),
                      'corporate_email' => request('corporate_email'),
                      'map_link' => request('map_link'),
                      'about_detail' => request('about_detail'),
                      'logo' => request('logo'),
                      'icon' => request('icon'),
                      'home_banner' => request('home_banner'),
                      'contact_banner' => request('contact_banner'),
                      'about_banner' => request('about_banner'),
                      'home_mobile_banner' => request('home_mobile_banner'),
                      'contact_mobile_banner' => request('contact_mobile_banner'),
                      'about_mobile_banner' => request('about_mobile_banner'),
                      'about_image' => request('about_image'),
                  );

      if(request('id')){

        $data['id'] = request('id');
        $data['multi_selected_home'] = request('multi_selected_home');
        $data['multi_selected_contact'] = request('multi_selected_contact');
        $data['multi_selected_about'] = request('multi_selected_about');

        $data['multi_selected_home_mobile'] = request('multi_selected_home_mobile');
        $data['multi_selected_contact_mobile'] = request('multi_selected_contact_mobile');
        $data['multi_selected_about_mobile'] = request('multi_selected_about_mobile');
        
        $data['multi_selected_aboutimage'] = request('multi_selected_aboutimage');
        $data['multi_selected_logo_image'] = request('multi_selected_logo_image');
        $data['multi_selected_icon_image'] = request('multi_selected_icon_image');

        $this->homesService->updateCms($data);
      }else{
      
        $this->homesService->createCms($data);
      }

    });

    // Return the transaction response.
    $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
    return response()->json($response);
  }

}
