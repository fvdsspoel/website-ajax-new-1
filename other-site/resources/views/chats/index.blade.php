<!DOCTYPE html>
<html>
    @section('styles')
        <link href="{{ asset('assets/css') }}/chat.css" rel="stylesheet">
        <style type="text/css">
            .sent {
                /*padding:10px;*/
                /*border-radius: 10px 10px 0 10px;*/
                white-space: pre-wrap;
                text-align: right;
                margin-left: 50% !important;
                margin-bottom: 10px;
                /*background-color: #2196f3;*/
                color: white;
                /*float: right;*/
                /*margin-right: 7px;*/
                max-width: 80%;
            }
        </style>
    @endsection
        @include('layouts.head', ['title' => 'CHAT'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>CHAT INQUIRY</strong></h5>
                </div>
                <div class="card-body">
                    <table class="table border table-td-top" style="height: 90vh !important">
                        <tr style="height: 1%">
                            <td style="width: 30%">
                               <!--  <button type="button" class="btn btn-sm btn-success float-right" id="compose_btn">
                                    <i class="fa fa-edit"></i> Compose
                                </button> -->
                                Conversations
                            </td>
                            <td class="border-left">
                                <center><span id="title">Select Conversation</span></center>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-0" rowspan="2" style="height: 100%">
                                <div style="height: inherit; overflow-y: scroll;" id="messages">
                                    @foreach($conversations as $conversation)
                                    <div class="p-2 border-bottom div-hover view-conversation {{$conversation->seen == 0 ? 'unread' : ''}}" id="conversation-{{$conversation->id}}" value="{{$conversation->id}}">
                                        <span class="date small float-right">{{date('M d, Y h:i A', strtotime($conversation->updated_at))}}</span>
                                        <span>{{$conversation->title ?? 'Client Inquiry'}}</span>
                                        <br>
                                        <span class="message small">{{$conversation->last_message}}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="border-left p-0" style="height: 100%">
                                <div class="p-3" style="display: none" id="compose">
                                    <input type="text" class="form-control" id="search_user" placeholder="Search user">
                                </div>
                                <div class="p-4" style="height: inherit; overflow-y: scroll;" id="chats"></div>
                            </td>
                        </tr>
                        <tr style="height: 1%">
                            <td class="border-left">
                                <!-- <form id="message_form"> -->
                                    <textarea class="form-control" placeholder="Write a message" required minlength="1" id="message_text"></textarea>
                                    <button class="btn btn-primary float-right mt-2" onclick="sendMessage();"><i class="fa fa-paper-plane"></i> Send</button>
                                <!-- </form> -->
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="hidden" id="current-user" value="{{$current_user->id ?? ''}}">
            <input type="hidden" id="send-to">
            @endsection
        @include('layouts.side-nav', ['title' => 'CHAT'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/assets/js/globalfunction.js?v=2.0"></script>
    <script type="text/javascript" src="/js/chats/chat.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>