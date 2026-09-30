<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->init();
        });
    }

    private function init() {
        $this->order_number = self::createID();
    }
    /* Static Methods */
    public static function createID() 
    {
        $today = date('Y-m-d');
        $count = self::whereDate('created_at',$today)->count() + 1;
        return "OR-".date('Ymd')."-$count";
    }

    protected $appends = [
        'label'
    ];

    //for init auto complte label data-> your data want to show
    public function getLabelAttribute() {
        return $this->first_name .' '. $this->last_name;
    }

    public static function paginatedSearch($keyword){

        $results = self::where(function($q) use($keyword) {
                            $q->where('order_number', 'LIKE', '%'.$keyword.'%')
                              ->orwhere('first_name', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('phone_no', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('appointment_date', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('appointment_time', 'LIKE', '%'.$keyword.'%')
                              ->orWhereHas('product',function($q) use($keyword){
                                $q->where('name', 'LIKE', '%'.$keyword.'%');
                              });
                        })
                        ->whereNull('deleted_at')
                        ->paginate(10);

        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);

        return $results;
    }


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function productStyle()
    {
        return $this->hasOne(ProductStyle::class, 'id', 'style_id');
    }

    public function productColor()
    {
        return $this->hasOne(ProductColor::class, 'id', 'color_id');
    }
}
