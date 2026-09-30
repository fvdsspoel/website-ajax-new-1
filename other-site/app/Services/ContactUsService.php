<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\ContactUs;
use Auth;

class ContactUsService{

    public function list($keyword){
        return  ContactUs::paginatedSearch($keyword);
    }

    public function store($request){

    	ContactUs::create([
        	    					'name' => request('name') ?? '',
        	    					'email' => request('email') ?? '',
        	    					'phone' => request('phone') ?? '',
        	    					'subject' => request('subject') ?? '',
        	    					'message' => request('message') ?? '',
        	    					'type' => request('type') ?? ''
        	    				]);

   		return 'saved';
    }
}     
