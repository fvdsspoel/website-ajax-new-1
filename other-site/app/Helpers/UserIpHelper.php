<?php

namespace App\Helpers;

use App\User;
use App\UserIp;
use Illuminate\Support\Facades\Hash;

class UserIpHelper
{
    public static function getUserIp()
    {
        $ip=null;
        $ip_user = [];
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){

                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        $check_ip_exist = UserIp::where('ip',$ip)->first();

                        if($check_ip_exist){
                            return $check_ip_exist;
                        }else{
                            $temp = count(UserIp::get()) + 1;
                            $email = 'buyeraccount'.$temp.'@sterk.ph';
                            $id = User::create([
                                'first_name'=>'buyeraccount'.$temp,
                                'last_name'=>'buyeraccount'.$temp,
                                'email'=>$email,
                                'password'=>Hash::make('12345678'),
                                'user_type'=> 2,
                                'is_ip_user' => 1,
                            ])->id;

                            UserIp::create([
                                'ip'        => $ip,
                                'name'      => 'buyeraccount'.$temp,
                                'email'     => $email,
                                'user_id'   => $id,
                            ]);

                            $ip_user = UserIp::where('ip',$ip)->first();
                        }
                    }
                }
            }
        }
        if (empty($ip_user)) {
            $ip_user = UserIp::first();
        }
        return $ip_user;
    }


    public static function getIp()
    {
        $return_ip=null;
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){

                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        $return_ip = $ip;
                    }

                }
            }
        }
        return $return_ip;
    }
}
