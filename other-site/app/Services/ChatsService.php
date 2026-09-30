<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Helpers\UserIpHelper;
use App\UserIp;
use App\User;
use App\Conversation;
use App\ConversationMember;
use App\Message;
use Carbon\Carbon;
use Auth;

class ChatsService{

	public function getChatUser(){
		if(Auth::user()){
          $ourcurrent = Auth::user()->id;
      }else{
          $ourcurrent = UserIpHelper::getUserIp() ?? UserIp::first();
          $ourcurrent = $ourcurrent->user_id ?? '';
      }
      return $ourcurrent;
	}

	public function getSupportId(){
		return User::where('email','support@sterk.ph')->first();
	}

	public function getLastConvoId($user_id){

		$convo = Conversation::where('created_by',$user_id)->first();
		return $convo->id ?? null;
	}

	public function getChatMessage($id){

		$user = $this->getChatUser();
		$conversation = Conversation::where('id', $id)
		                ->with([
				                    'members.userId:id,name',
				                    'messages.createdBy:id,name',
				                    'createdBy:id,name',
				                    // 'chatPropertyName'
				                ])
		                ->first();
		ConversationMember::where('conversation_id', $id)->where('user_id', $user->id)->update(['seen' => 1]);
		return $conversation;
	}

	public function storeMessage($request){

		$user = $this->getChatUser();
		$sender = User::select('id','email','first_name as name')->where('id',$user)->first();
		$message = $request->message;
		$send_to = $request->send_to;

		if($request->product_type == 'Buildable'){
			$column_name = 'product_id';
		}else{
			$column_name = 'non_build_product_id';
		}

		$id = Conversation::insertGetId([
		        'created_by' => $user,
		        $column_name => $request->product_id ?? null,
		        'created_at' => now(),
		        'updated_at' => now()
		    ]);

		ConversationMember::insert([
		    'conversation_id' => $id,
		    'user_id' => $user,
		    'seen' => 1
		]);

		ConversationMember::insert([
		    'conversation_id' => $id,
		    'user_id' => $send_to
		]);

		Message::insert([
		    'conversation_id' => $id,
		    'message' => $message,
		    'created_by' => $user,
		    'created_at' => now(),
		    'updated_at' => now(),
		]);

		$conversation = Conversation::find($id);
		foreach ($conversation->members as $key => $value) {
		    $receivers[] = $value->user_id;
		}

		$receiver = User::select('id','email','first_name as name','last_active_time')->find($send_to);


		$response_array = [
		    'id' => $conversation->id,
		    'title' => null,
		    'last_message' => $conversation->last_message,
		    'receivers' => $receivers ?? [],
		    'date' => $conversation->formatted_last_message_date,
		    'receiver' => $receiver,
		    'sender' => $sender
		];

		if($request->auto_reply == 1) {
		    $receiver_active_time = $receiver->last_active_time ?? Carbon::now()->subYears(30)->startOfYear();
		    if ($receiver_active_time >= Carbon::now()->subMinutes(10)) {
		    } elseif ($receiver_active_time >= Carbon::now()->subMinutes(60)) {
		    } else {
		        $id1 = Message::insertGetId([
		            'conversation_id' => $id,
		            'message' => 'Hi sorry currently I’m busy right now can I ask your email and contact information so I can reach you later. Thank you',
		            'created_by' => $receiver->id,
		            'created_at' => now(),
		            'updated_at' => now(),
		        ]);
		        $message1 = Message::with('createdBy:id,first_name')->find($id1);
		        $response_array['auto_reply'] = $message1;

		        Conversation::where('id', $id)
		            ->update([
		                'auto_reply_time' => Carbon::now()
		            ]);
		    }
		}

		return $response_array;
	}

	public function sendMessage($request){

		$user = $this->getChatUser();

		$cid = $request->cid;
        $message = $request->message ?? '';

        $id = Message::insertGetId([
                'conversation_id' => $cid,
                'message' => $message,
                'created_by' => $user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        $message = Message::with('createdBy:id,first_name')->find($id);
        Conversation::where('id', $cid)->update(['updated_at' => now()]);
        ConversationMember::where('conversation_id', $cid)->where('user_id', '<>', $user)->update(['seen' => 0]);

        $receiver = ConversationMember::where('conversation_id', $cid)->where('user_id', '!=', $user)->first();
        $receiver_id = $receiver->user_id;

        $receiver_active_time = $receiver->user->last_active_time ?? Carbon::now()->subYears(30)->startOfYear();
        if($request->auto_reply == 1) {

            $conversation = Conversation::where('id', $cid)->first();
            if(!Auth::user()){
            	if (($conversation->auto_reply_time == null) || ($conversation->auto_reply_time < Carbon::now()->subHour())) {
            	    if ($receiver_active_time >= Carbon::now()->subMinutes(10)) {
            	    } elseif ($receiver_active_time >= Carbon::now()->subMinutes(60)) {
            	    } else {
            	        $id1 = Message::insertGetId([
            	            'conversation_id' => $cid,
            	            'message' => 'Hi sorry currently I’m busy right now can I ask your email and contact information so I can reach you later. Thank you',
            	            'created_by' => $receiver_id,
            	            'created_at' => now(),
            	            'updated_at' => now(),
            	        ]);
            	        $message1 = Message::with('createdBy:id,first_name')->find($id1);
            	        $message->auto_reply = $message1;
            	        Conversation::where('id', $cid)
            	            ->update([
            	                'auto_reply_time' => Carbon::now()
            	            ]);
            	    }
            	}
            }
        }

        return $message;
	}

	public function showMessage($id){

		$user = $this->getChatUser();
		$conversation = Conversation::where('id', $id)
                        ->with([
                            'members.userId:id,first_name',
                            'messages.createdBy:id,first_name',
                            'createdBy:id,first_name'
                        ])
                        ->first();
        ConversationMember::where('conversation_id', $id)->where('user_id', $user)->update(['seen' => 1]);

        return $conversation;
	}

	public function list($request){

		$user = $this->getChatUser();
		return Conversation::whereHas('members', function($q) use($user) {
                            $q->where('user_id', $user);
                        })
                        ->orderBy('updated_at', 'DESC')
                        ->get();
	}
}