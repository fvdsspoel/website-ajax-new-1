<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function paginatedSearch($keyword,$category_id,$sub_category_id,$min,$max,$is_active){

        $results = self::where(function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->whereNull('deleted_at');

        if($is_active){
            $results = $results->where('active',1);
        }

        if($category_id){
            $results = $results->where('category_id',$category_id);
        }

        if($sub_category_id){
            $results = $results->where('sub_category_id',$sub_category_id);
        }

        if($min){
            $results = $results->whereBetween('price',[$min,$max]);
        }

        $results = $results->paginate(9);

        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 9
        ]);

        return $results;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subCategory()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function productStyle()
    {
        return $this->hasMany(ProductStyle::class, 'product_id', 'id')->whereNull('deleted_at')->whereNull('deleted_by');
    }
}
