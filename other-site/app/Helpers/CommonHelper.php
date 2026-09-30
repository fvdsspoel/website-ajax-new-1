<?php

namespace App\Helpers;

use App\Property;
use App\PropertyUnit;
use App\ServicesProvider;
use App\SystemSettings;
use App\UserType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class CommonHelper
{
    public static function getSideNavUserType()
    {
        $type = UserType::where('id',Auth::user()->user_type)->first();
        return $type->name;
    }

    public static function showDate($date, $format = 'Y-m-d')
    {
        if ($date!='') {
            return Carbon::make($date)->format($format);
        }
        return '';
    }

    public static function getCurrencySign()
    {
        return config('sitedata.currency_sign');
    }
    public static function getUserType($user)
    {
        if ($user->agent_type == 'Private Seller') {
            return 'Property Owner';
        }
        return $user->user_type;
    }
    public static function getRealString($string)
    {
        $string = strip_tags($string);
        $string = str_replace("&nbsp;", ' ', $string);
        return trim($string);
    }

    public static function getSubStr(string $string, int $length, $extra='...')
    {
        if (mb_strlen($string) > $length) {
            return mb_substr($string, 0, $length).$extra;
        } else {
            return $string;
        }
    }

    public static function getShowPropertyLocation($property)
    {
        return $property->location_text ?? ' ';
        $location = '';
        $location .= $property->propertyLocation->street ?? '';
        $location .= $property->propertyLocation->subdivision ?? '';
        $location .= $property->propertyLocation->zipcode->cityId->provinceId->label ?? '';
        $location .= $property->propertyLocation->zipCode->cityId->city ?? '';
        $location .= $property->propertyLocation->zipcode->zip_code_number ?? '';
        return $location;
    }

    public static function getNoImage($image)
    {
        if(file_exists($image)) {
            return $image;
        }
        return asset('/images/no_image.png');
    }

    /*Insert Session add listing data*/
    public static function insertAddListing()
    {
        if (Session::has('add_listing_request')) {
            DB::beginTransaction();
            try {
                $req_data = Session::get('add_listing_request');
                $proeprty = Property::create([
                    'name' => $req_data->property_name,
                    'price' => $req_data->price,
                    'inquiry' => $req_data->inquiry_type,
                    'property_type' => $req_data->property_type,
                    'beds' => $req_data->beds,
                    'lat' => $req_data->lat,
                    'lng' => $req_data->lng,
                    'location_text' => $req_data->location_text,
                    'added_by' => auth()->id(),
                    'is_deleted' => 0,
                ]);

                $property_unit = PropertyUnit::create([
                    'property_id' => $proeprty->id,
                    'unit' => $req_data->unit,
                    'bed' => $req_data->bed,
                    'bath' => $req_data->bath,
                ]);
            } catch (\Exception $exception) {
                DB::rollBack();
                return [
                    'status' => 500,
                    'msg' => $exception->getMessage(),
                    'property' => ''
                ];
            }
            DB::commit();

            return [
                'status' => 200,
                'msg' => 'Success',
                'property' => $proeprty
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }

    /*Insert Session add service listing data*/
    public static function insertAddListingService()
    {
        if (Session::has('add_listing_service_request')) {
            DB::beginTransaction();
            try {
                $req_data = Session::get('add_listing_service_request');
                $auth_user = auth()->user();
                if(($auth_user->lat == '') || ($auth_user->lng == '')) {
                    $auth_user->lat = $req_data->lat;
                    $auth_user->lng = $req_data->lng;
                    $auth_user->address = $req_data->location_text;
                    $auth_user->save();
                }
                $service = ServicesProvider::create([
                    'name'=>$req_data->service_name,
                    'price'=>$req_data->price,
                    'category'=>$req_data->category,
                    'lat'=>$req_data->lat,
                    'lng'=>$req_data->lng,
                    'location_text'=>$req_data->location_text,
                    'added_by'=>$auth_user->id,
                    'is_deleted'=>0,
                ]);
            } catch (\Exception $exception) {
                DB::rollBack();
                return [
                    'status' => 500,
                    'msg' => $exception->getMessage(),
                    'property' => ''
                ];
            }
            DB::commit();

            return [
                'status' => 200,
                'msg' => 'Success',
                'service' => $service
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }

    public static function defaultMapLatLng()
    {
        $ret_data = [
            'lng' => 90.3,
            'lat' => 23.79
        ];
        $system_settings = SystemSettings::first();
        if (!empty($system_settings)) {
            if(($system_settings->map_center_lng != '') && ($system_settings->map_center_lat != '')) {
                $ret_data = [
                    'lng' => $system_settings->map_center_lng,
                    'lat' => $system_settings->map_center_lat
                ];
            }
        }

        return $ret_data;
    }

    public static function userDefaultMapLatLng($user)
    {
        $ret_data = [
            'lng' => 90.3,
            'lat' => 23.79
        ];
        if (($user->lat != '') && ($user->lng != '')) {
            $ret_data = [
                'lng' => $user->lng,
                'lat' => $user->lat
            ];
        } else {
            $system_settings = SystemSettings::first();
            if (!empty($system_settings)) {
                if (($system_settings->map_center_lng != '') && ($system_settings->map_center_lat != '')) {
                    $ret_data = [
                        'lng' => $system_settings->map_center_lng,
                        'lat' => $system_settings->map_center_lat
                    ];
                }
            }
        }

        return $ret_data;
    }


    public static function getCommentUserImage($comment)
    {
        if (($comment->user_id == null) || ($comment->user_id == 0)) {
            return '/images/no_image.png';
        } else {
            return $comment->user->userDetail->image ?? '/images/no_image.png';
        }
    }

    public static function getLink($link) {
        if ($link == '') {
            $link = "#";
        } elseif (substr($link, 0,4) != "http") {
            $link = "http://".$link;
        }

        return $link;
    }

    public static function showPdfAmount($amount, $decimal=2)
    {
        return number_format($amount,$decimal);
    }
}
