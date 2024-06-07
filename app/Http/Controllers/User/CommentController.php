<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    protected $comment;


    public function __construct(){

        $this->comment = new Comment();
        
    }


    public function addComment(Request $req, $movieId){
        $userId = Auth::id();
        $validator = Validator::make($req->all(),[
            'comment_content' => 'required'
        ],[
            'comment_content.required' => 'Nội dung bình luận không để trống'
        ]);
        if($validator->passes()){
            $data_comment = [
                'u_id' => $userId,
                'm_id' => $movieId,
                'c_Description' => $req->comment_content,
                'c_Reply' => $req->c_Reply ? $req->c_Reply : 0
            ];
            $comment = $this->comment;
            $commentId = $this->comment->insertComment($data_comment);
            $commentByCommentId = $this->comment->getCommentByCommentId($commentId);

            $countComment = $this->comment->getCountCommentByMovieId($movieId);
            
            return response()->json(['view' => view('user.itemCmtResFromAjax', compact('comment', 'commentByCommentId'))->render(), 'countComment' => $countComment.' bình luận']);
        }

        return response()->json(['error' => $validator->errors()->first()]);
    }

    public function editComment(Request $req){
        $this->comment->editComment($req->commentId, $req->desEdit);
        
        return response()->json(['success' => 'done']);
        
    }

    public function deleteComment(Request $req){
        if($this->comment->deleteComment($req->commentId)){
            return response()->json(['success' => 'Xóa thành công']);
        }else{
            return response()->json(['error' => 'Xóa không thành công']);
        }
    }
}
