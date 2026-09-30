<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonBuildProduct extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function paginatedSearch($keyword){

        $results = self::where(function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->whereNull('deleted_at')
                        ->paginate(10);

        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);

        return $results;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function nonBuildSubProduct()
    {
        return $this->hasMany(NonBuildSubProduct::class, 'product_id', 'id')->whereNull('deleted_at');
    }
}
