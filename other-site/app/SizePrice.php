<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizePrice extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected $appends = [
        'price_format'
    ];

    //for init auto complte label data-> your data want to show
    public function getPriceFormatAttribute() {
        return '₱ ' . number_format($this->price ?? 0,2);
    }

    public static function paginatedSearch($keyword){

        $results = self::whereNull('deleted_at')->paginate(10);

        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);

        return $results;
    }
}
