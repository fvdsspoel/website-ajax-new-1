<?php

namespace App\Helpers;

use App\Helpers\UserIpHelper;
use App\UserIp;
use App\User;
use App\Conversation;
use Auth;

class ChatHelper
{
    public static function getChatUser(){
        if(Auth::user()){
          $ourcurrent = Auth::user()->id;
      }else{
          $ourcurrent = UserIpHelper::getUserIp() ?? UserIp::first();
          $ourcurrent = $ourcurrent->user_id ?? '';
      }
      return $ourcurrent;
    }

    public static function getSupportId(){
        return User::where('email','support@sterk.ph')->first();
    }

    public static function getLastConvoId($user_id){
        $convo = Conversation::where('created_by',$user_id)->whereNull('non_build_product_id')->whereNull('product_id')->first();
        return $convo->id ?? null;
    }

    public static function getLastProductConvoId($user_id,$id,$column_name = 'product_id'){
        $convo = Conversation::where('created_by',$user_id)->where($column_name,$id)->first();
        return $convo->id ?? null;
    }
}
