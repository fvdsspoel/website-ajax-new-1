<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatsService;
use Auth;

class ChatsController extends Controller
{   
    public function __construct(ChatsService $chatsService){
      $this->chatsService = $chatsService;
    }

    public function chatMessages($id,Request $request){
    	$conversation = $this->chatsService->getChatMessage($id);
    	return response()->json($conversation);
    }

    public function storeMessage(Request $request){
    	$response_array = $this->chatsService->storeMessage($request);
    	return response()->json($response_array);
    }

    public function sendMessage(Request $request){
    	$response_array = $this->chatsService->sendMessage($request);
    	return response()->json($response_array);
    }

    public function showMessage($id){
    	$response_array = $this->chatsService->showMessage($id);
    	return response()->json($response_array);
    }

    /*CRUD*/
    public function list(Request $request){
        $conversations = $this->chatsService->list($request);
        $current_user = $this->chatsService->getSupportId();
        return view('chats.index', compact('conversations','current_user'));
    }
}
