<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactUsService;
use DB;

class ContactUsController extends Controller
{
	private $contactUsService;

	public function __construct(ContactUsService $contactUsService){

	  $this->contactUsService = $contactUsService;
	}

    public function contactUs()
    {
        return view('front-ends.contact-us.index');
    }

    public function corporateInquiry()
    {
        return view('front-ends.contact-us.corporate');
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $results = $this->contactUsService->list($keyword);
        return view('inquries.index',compact('keyword','results'));
    }

    public function store(Request $request)
    {
        $has_exceptions = DB::transaction(function() use($request) {
			
			$this->contactUsService->store($request);

        });

        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
}
