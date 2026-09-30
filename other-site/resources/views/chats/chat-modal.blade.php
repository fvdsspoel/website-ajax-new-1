<div id="chat-modal" style="display: none;">
    <div class="chat-modal-dialog" role="document">
        <div class="chat-modal-content">
            <div class="modal-header" style="">
                <div class="chat-header-wrapper">
                    <img src="/assets/images/icons/user.webp" alt="" style="">
                    <div class="extra">
                        <h6 id="property-title">
                            Support Agent
                        </h6>
                        <p id="sub-title">
                            Ajax Trading Corporation
                        </p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="chat-body">
                <table class="table table-td-top" style="height: 50vh !important;bottom: 0;">
                    <tr>
                        <td class="border-left p-0" style="height: 100%">
                            <div class="p-2" style="height: inherit; overflow-y: scroll;" id="chats"></div>
                        </td>
                    </tr>
                    <tr style="height: 1%">
                        <td class="border-left">
                            <div id="message_form">
                                <textarea class="form-control" placeholder="Write a message" required minlength="1" id="message_text"></textarea>
                                <button class="btn btn-primary float-right mt-2" id="chatMessageSendBtn" onclick="sendMessage();"><i class="fa fa-paper-plane"></i> </button>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="last-convo" value="{{\App\Helpers\ChatHelper::getLastConvoId(\App\Helpers\ChatHelper::getChatUser())}}">
                <input type="hidden" id="send-to" value="{{\App\Helpers\ChatHelper::getSupportId()->id ?? ''}}">
                <input type="hidden" id="current-user" value="{{\App\Helpers\ChatHelper::getChatUser()}}">
            </div>
        </div>
    </div>
</div>
