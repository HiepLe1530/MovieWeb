
<div class="media d-flex mt-4">
    <img src="/images/{{ $comment->getUserCommentByUserId($commentParrent->u_id)->u_Avatar }}" alt="" class=" rounded-circle" width="60px" height="60px">
    <div class="list_comment flex-grow-1 ms-3">
        <div class="d-flex align-items-center mb-1">
            <h5 class="userName userName_{{ $commentParrent->id }} me-3 mb-0">{{ $comment->getUserCommentByUserId($commentParrent->u_id)->u_UserName }}</h5> 
            <span class="timestamp text-light "><i class="fa-regular fa-clock me-1"></i> {{ $commentParrent->c_Timestamp }}</span>
            @if (Auth::id() == $comment->getUserCommentByUserId($commentParrent->u_id)->id)
                <div class="ms-3">
                    <span style="cursor: pointer" onclick="editComment({{ $commentParrent->id }})"><i class="fa-solid fa-pen-to-square" style="color: green"></i></span>
                    <span style="cursor: pointer" onclick="deleteComment({{ $commentParrent->id }})"><i  class="fa-solid fa-trash" style="color: red"></i></span>
                </div>
            @endif
            
        </div>
        <p class="comment_content_{{ $commentParrent->id }}" style="color: aliceblue;">{{ $commentParrent->c_Description }}</p>
        @if (Auth::id() == $comment->getUserCommentByUserId($commentParrent->u_id)->id)
            <div class="edit_input_{{ $commentParrent->id }}" style="display: none">
                <form method="">
                    <textarea class="comment_content_textarea form-control " name="comment_content" id="comment_content_edit_{{ $commentParrent->id }}"  rows="2"></textarea>
                    <div class="d-flex justify-content-end mt-1">
                        <button class="me-1" id="" data-id="" 
                        style="background:#5c5454; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                        onclick="return cancelEditComment({{ $commentParrent->id }})">Hủy</button>
                        <button class="" id="" data-id="" 
                        style="background:green; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                        onclick="return saveEditComment({{ $commentParrent->id }}, '{{ route('home.editComment') }}')">Lưu</button>
                    </div>
                    <small class="comment_error_edit_{{ $commentParrent->id }}" style="color: red; position:relative; top:-35px;"></small>
                </form>
            </div>
        @endif
        
        @if (Auth::check())
            <button class="btn btn-link btn_reply" data-id="{{ $commentParrent->id }}"><i class="fa-solid fa-diamond-turn-right me-2"></i>Phản hồi</button>
        

            <div class="form_reply form_reply_{{ $commentParrent->id }}">
                <div class="row mt-2 gx-0">
                    <div class="col-md-2 col-lg-1 col-xl-2 col-xxl-1"><img src="/images/{{ Auth::user()->u_Avatar }}" alt="" class="rounded-circle" width="60px" height="60px" style="margin: 10px 0;"></div>
                    <div class="form-group col-md-10 col-lg-11 col-xl-10 col-xxl-11">
                        <form method="">
                            <input type="hidden" value="{{ $commentParrent->id }}" name="c_Reply" class="commentParrentId_{{ $commentParrent->id }}">
                            <textarea class="comment_content_textarea form-control " name="comment_content" placeholder="Tham gia bình luận" id="comment_content_{{ $commentParrent->id }}"  rows="2"></textarea>
                            <button class="btn_send_comment" id="btn_send_comment_reply_{{ $commentParrent->id }}" data-id="{{ $commentParrent->id }}" style="">Gửi</button>
                            <small class="comment_error_{{ $commentParrent->id }}" style="color: red;"></small>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div id="list_comment_child_{{ $commentParrent->id }}">
            @if (!empty($comment->getCommentChild($commentParrent->m_id, $commentParrent->id)))
                @foreach ($comment->getCommentChild($commentParrent->m_id, $commentParrent->id) as $commentChild)
                    <div class="media d-flex mt-3">
                        <img src="/images/{{ $comment->getUserCommentByUserId($commentChild->u_id)->u_Avatar }}" alt="" class=" rounded-circle" width="60px" height="60px">
                        <div class="list_comment flex-grow-1 ms-3">
                            <div class="d-flex align-items-center mb-1">
                                <h5 class="userName userName_{{ $commentChild->id }} me-3 mb-0">{{ $comment->getUserCommentByUserId($commentChild->u_id)->u_UserName }}</h5> 
                                <span class="timestamp text-light"><i class="fa-regular fa-clock me-1"></i> {{ $commentChild->c_Timestamp }}</span>
                                @if (Auth::id() == $comment->getUserCommentByUserId($commentChild->u_id)->id)
                                    <div class="ms-3">
                                        <span style="cursor: pointer" onclick="editComment({{ $commentChild->id }})"><i class="fa-solid fa-pen-to-square" style="color: green"></i></span>
                                        <span style="cursor: pointer" onclick="deleteComment({{ $commentChild->id }})"><i  class="fa-solid fa-trash" style="color: red"></i></span>
                                    </div>
                                @endif
                            </div>
                            <p class="comment_content_{{ $commentChild->id }}" style="color: aliceblue;">{{ $commentChild->c_Description }}</p>

                            @if (Auth::id() == $comment->getUserCommentByUserId($commentChild->u_id)->id)
                                <div class="edit_input_{{ $commentChild->id }}" style="display: none">
                                    <form method="">
                                        <textarea class="comment_content_textarea form-control " name="comment_content" id="comment_content_edit_{{ $commentChild->id }}"  rows="2"></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <button class="me-1" id="" data-id="" 
                                            style="background:#5c5454; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                                            onclick="return cancelEditComment({{ $commentChild->id }})">Hủy</button>
                                            <button class="" id="" data-id="" 
                                            style="background:green; padding:5px 10px;border-radius: 10px; color:azure; border: none;"
                                            onclick="return saveEditComment({{ $commentChild->id }}, '{{ route('home.editComment') }}')">Lưu</button>
                                        </div>
                                        <small class="comment_error_edit_{{ $commentChild->id }}" style="color: red; position:relative; top:-35px;"></small>
                                    </form>
                                </div>
                            @endif

                            @if (Auth::check())
                                <button class="btn btn-link btn_reply" data-id="{{ $commentChild->id }}"><i class="fa-solid fa-diamond-turn-right me-2"></i>Phản hồi</button>
                            
                                <div class=" form_reply form_reply_{{ $commentChild->id }}">
                                    <div class="row mt-2">
                                        <div class="col-md-2 col-lg-1 col-xl-2 col-xxl-1"><img src="/images/{{ Auth::user()->u_Avatar }}" alt="" class="rounded-circle" width="60px" height="60px" style="margin: 10px 0;"></div>
                                        <div class="form-group col-md-10 col-lg-11 col-xl-10 col-xxl-11">
                                            <form method="">
                                                <input type="hidden" value="{{ $commentParrent->id }}" name="c_Reply" class="commentParrentId_{{ $commentChild->id }}">
                                                <textarea class="comment_content_textarea form-control " name="comment_content" placeholder="Tham gia bình luận" id="comment_content_{{ $commentChild->id }}"  rows="2"></textarea>
                                                <button class="btn_send_comment" id="btn_send_comment_reply_{{ $commentChild->id }}" data-id="{{ $commentChild->id }}" style="">Gửi</button>
                                                <small class="comment_error_{{ $commentChild->id }}" style="color: red"></small>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                @endforeach
            @endif      
        </div>
        
        
    </div>
</div>