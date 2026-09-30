<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonBuildSubProduct extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function paginatedSearch($keyword,$product_id){

        $results = self::where(function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
        				->where('product_id',$product_id)
                        ->whereNull('deleted_at')
                        ->whereNull('deleted_by')
                        ->paginate(9);

        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 9,
            'product_id' => $product_id
        ]);

        return $results;
    }

    public function nonBuildProduct()
    {
        return $this->hasOne(NonBuildProduct::class, 'id', 'product_id');
    }
}
