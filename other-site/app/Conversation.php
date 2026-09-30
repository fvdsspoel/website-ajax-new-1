<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\UserIpHelper;
use Carbon\Carbon;
use Auth;

class Conversation extends Model
{
	protected $appends = [
		'last_message',
		'formatted_last_message_date',
        'seen',
        'title',
	];

	public function getLastMessageAttribute() {
        $message = Message::where('conversation_id', $this->id)->orderBy('created_at', 'DESC')->first();
        return $message->message ?? '';
    }

    public function getFormattedLastMessageDateAttribute() {
        if($this->updated_at < Carbon::now()->startOfYear()) {
            return date('M d, Y h:i A', strtotime($this->updated_at));;
        } elseif ($this->updated_at < Carbon::now()->startOfDay()) {
            return date('M d h:i A', strtotime($this->updated_at));
        }
        return date('h:i A', strtotime($this->updated_at));
    }

    public function getSeenAttribute() {
        if(Auth::user()){
            $member = ConversationMember::where('conversation_id', $this->id)->where('user_id', request()->user()->id)->first();
            return $member->seen ?? 0;
        }else{
            return 0;
        }
    }

    public function getTitleAttribute() {

        if($this->product_id){
            return 'Client Inquiry for ' . $this->product->name ?? '';
        }else if($this->non_build_product_id){
            return 'Client Inquiry for ' . $this->nonBuildSubProduct->name ?? '';
        }else{
            return 'Client Inquiry';
        }
    }

	public function members() {
	    return $this->hasMany(ConversationMember::class, 'conversation_id', 'id');
	}

	public function messages() {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function nonBuildSubProduct() {
        return $this->hasOne(NonBuildSubProduct::class, 'id', 'non_build_product_id');
    }
}
