<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFeatureDetail extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function productFeature()
    {
        return $this->hasOne(ProductFeature::class, 'id', 'feature_id')->whereNull('deleted_at');
    }
}
