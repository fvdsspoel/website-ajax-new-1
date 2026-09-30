<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function productStyle()
    {
        return $this->hasOne(ProductStyle::class, 'id', 'style_id');
    }
}
