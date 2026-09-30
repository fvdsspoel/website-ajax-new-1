<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Appointment;

class AppointmentsService{

	public function list($keyword){
  		return  Appointment::paginatedSearch($keyword);
	}

  public function getData($id){
    return  Appointment::where('id',$id)->first();
  }
}     
