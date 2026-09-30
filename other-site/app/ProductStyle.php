<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStyle   extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
