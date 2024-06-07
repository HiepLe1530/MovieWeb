<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $currentTime;

    public function __construct(){

        Carbon::setLocale('vi');
        // Thời gian hiện tại
        $this->currentTime = Carbon::now();
        
    }

    public function getCommentParrent($movieId, $c_Reply=0){
        $comment = DB::table($this->table)->where('m_id', $movieId)->where('c_Reply', $c_Reply)->orderBy('id', 'DESC')->get()->toArray();

        for($i = 0; $i < count($comment); $i++){
            // Chuyển chuỗi thời gian thành đối tượng Carbon
            $timestamp = Carbon::parse($comment[$i]->c_Timestamp);
             // So sánh thời gian
            $timeDiff = $timestamp->diffForHumans($this->currentTime);
            $comment[$i]->c_Timestamp = $timeDiff;
        }

        return $comment;
    }

    public function getCommentChild($movieId, $c_Reply=0){
        $comment = DB::table($this->table)->where('m_id', $movieId)->where('c_Reply', $c_Reply)->get()->toArray();

        for($i = 0; $i < count($comment); $i++){
            // Chuyển chuỗi thời gian thành đối tượng Carbon
            $timestamp = Carbon::parse($comment[$i]->c_Timestamp);
             // So sánh thời gian
            $timeDiff = $timestamp->diffForHumans($this->currentTime);
            $comment[$i]->c_Timestamp = $timeDiff;
        }

        return $comment;
    }

    public function getCommentByCommentId($commentId){
        $comment = DB::table($this->table)->where('id', $commentId)->first();

        // Chuyển chuỗi thời gian thành đối tượng Carbon
        $timestamp = Carbon::parse($comment->c_Timestamp);
            // So sánh thời gian
        $timeDiff = $timestamp->diffForHumans($this->currentTime);
        $comment->c_Timestamp = $timeDiff;
        
        return $comment;
    }

    public function getUserCommentByUserId($userId){
        return DB::table('users')
        ->where('id', $userId)
        ->first();
    }

    public function insertComment($comment){
        $commentId = DB::table($this->table)->insertGetId($comment);
        return $commentId;
    }

    public function editComment($commentId, $desEdit){
        return DB::table($this->table)->where('id', $commentId)->update([
            'c_Description' => $desEdit
        ]);
    }

    public function deleteComment($commentId){
        return DB::table($this->table)->where('id', $commentId)->orWhere('c_Reply', $commentId)->delete();
    }

    public function getCountCommentByMovieId($movieId){
        return DB::table($this->table)->where('m_id', $movieId)->count();
    }
}
