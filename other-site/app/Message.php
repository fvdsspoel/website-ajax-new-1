<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $appends = [
	    'formatted_date',
	    'deleted_users_array'
	];

	protected $guarded = [];

	public function getDeletedUsersArrayAttribute()
	{
	    if ($this->deleted_users === 0) {
	        return [0,'0'];
	    } elseif (($this->deleted_users == null) || ($this->deleted_users == '')) {
	        return [];
	    }

	    return explode(',', $this->deleted_users);
	}

	public function getFormattedDateAttribute() {
	    if($this->created_at < Carbon::now()->startOfYear()) {
	        return date('M d, Y h:i A', strtotime($this->created_at));;
	    } elseif ($this->created_at < Carbon::now()->startOfDay()) {
	        return date('M d h:i A', strtotime($this->created_at));
	    }
	    return date('h:i A', strtotime($this->created_at));
	}


	public function makeHttps($link)
	{
	    if(mb_substr($link, 0,5) != 'https') {
	        $link = 'https'.mb_substr($link,4);
	    }

	    return $link;
	}

	public function conversationId() {
	    return $this->hasOne(Conversation::class, 'id', 'conversation_id');
	}

	public function createdBy() {
	    return $this->hasOne(User::class, 'id', 'created_by');
	}
}
