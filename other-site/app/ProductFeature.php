<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function productFeatureDetail()
    {
        return $this->hasMany(ProductFeatureDetail::class, 'feature_id', 'id')->whereNull('deleted_at');
    }
}
