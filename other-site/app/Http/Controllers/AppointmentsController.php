<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppointmentsService;
use App\Services\ProductsService;

class AppointmentsController extends Controller
{
	public function __construct(AppointmentsService $appointmentsService,ProductsService $productsService){
		$this->appointmentsService = $appointmentsService;
        $this->productsService = $productsService;
	}

    public function index(Request $request)
    {
    	$keyword = $request->keyword;
        $results = $this->appointmentsService->list($keyword);
        return view('appointments.index',compact('keyword','results'));
    }

    public function view($id,Request $request)
    {
        $data = $this->appointmentsService->getData($id);
        $feature_details = [];
        $feature_arrs = explode(",",$data->feature_detail_id);
        foreach($feature_arrs as $feature_arr){
            $fd = $this->productsService->getFeatureDetail($feature_arr);
            if($fd){
                $feature_details[] = $fd;
            }
        }
        return view('appointments.view',compact('id','data','feature_details'));
    }
}
