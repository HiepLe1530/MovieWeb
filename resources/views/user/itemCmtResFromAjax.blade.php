
<div class="media d-flex mt-4">
    <img src="/images/{{ $comment->getUserCommentByUserId($commentByCommentId->u_id)->u_Avatar }}" alt="" class=" rounded-circle" width="60px" height="60px">
    <div class="list_comment flex-grow-1 ms-3">
        <div class="d-flex align-items-center mb-1">
            <h5 class="userName userName_{{ $commentByCommentId->id }} me-3 mb-0">{{ $comment->getUserCommentByUserId($commentByCommentId->u_id)->u_UserName }}</h5> 
            <span class="timestamp"><i class="fa-regular fa-clock me-1"></i> {{ $commentByCommentId->c_Timestamp }}</span>
            @if (Auth::id() == $comment->getUserCommentByUserId($commentByCommentId->u_id)->id)
                <div class="ms-3">
                    <span style="cursor: pointer" onclick="editComment({{ $commentByCommentId->id }})"><i class="fa-solid fa-pen-to-square" style="color: green"></i></span>
                    <span style="cursor: pointer" onclick="deleteComment({{ $commentByCommentId->id }})"><i  class="fa-solid fa-trash" style="color: red"></i></span>
                </div>
            @endif
        </div>
        <p class="comment_content_{{ $commentByCommentId->id }}" style="color: aliceblue;">{{ $commentByCommentId->c_Description }}</p>
        @if (Auth::id() == $comment->getUserCommentByUserId($commentByCommentId->u_id)->id)
            <div class="edit_input_{{ $commentByCommentId->id }}" style="display: none">
                <form method="">
                    <textarea class="comment_content_textarea form-control " name="comment_content" id="comment_content_edit_{{ $commentByCommentId->id }}"  rows="2"></textarea>
                    <div class="d-flex justify-content-end mt-1">
                        <button class="me-1" id="" data-id="" 
                        style="background:#5c5454; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                        onclick="return cancelEditComment({{ $commentByCommentId->id }})">Hủy</button>
                        <button class="" id="" data-id="" 
                        style="background:green; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                        onclick="return saveEditComment({{ $commentByCommentId->id }}, '{{ route('home.editComment') }}')">Lưu</button>
                    </div>
                    <small class="comment_error_edit_{{ $commentByCommentId->id }}" style="color: red; position:relative; top:-35px;"></small>
                </form>
            </div>
        @endif
        @if (Auth::check())
            <button class="btn btn-link btn_reply" data-id="{{ $commentByCommentId->id }}"><i class="fa-solid fa-diamond-turn-right me-2"></i>Phản hồi</button>
        

            <div class="form_reply form_reply_{{ $commentByCommentId->id }}">
                <div class="row mt-2">
                    <div class="col-lg-1 col-md-2"><img src="/images/{{ Auth::user()->u_Avatar }}" alt="" class="rounded-circle" width="60px" height="60px" style="margin: 10px 0;"></div>
                    <div class="form-group col-lg-11 col-md-10">
                        <form method="">
                            <input type="hidden" value="{{ ($commentByCommentId->c_Reply == 0) ? $commentByCommentId->id : $commentByCommentId->c_Reply }}" name="c_Reply" class="commentParrentId_{{ $commentByCommentId->id }}">
                            <textarea class="comment_content_textarea form-control " name="comment_content" placeholder="Tham gia bình luận" id="comment_content_{{ $commentByCommentId->id }}"  rows="2"></textarea>
                            <button class="btn_send_comment" id="btn_send_comment_reply_{{ $commentByCommentId->id }}" style="">Gửi</button>
                            <small class="comment_error_{{ $commentByCommentId->id }}" style="color: red"></small>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div id="list_comment_child_{{ ($commentByCommentId->c_Reply == 0) ? $commentByCommentId->id : $commentByCommentId->c_Reply }}">
                
        </div>
        
        
    </div>
</div>
