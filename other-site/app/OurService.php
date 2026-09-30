<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurService extends Model
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
}
