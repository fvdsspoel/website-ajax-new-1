<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteText extends Model
{
    protected $fillable = ['locale', 'key', 'value', 'updated_by'];
}
