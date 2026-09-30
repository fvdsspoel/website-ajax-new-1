<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory   extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
