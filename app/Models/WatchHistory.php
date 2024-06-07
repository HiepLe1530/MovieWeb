<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class WatchHistory extends Model
{
    use HasFactory;
    protected $table = 'watch_history';

    public function getHistoryByUserId($userId){
        return DB::table($this->table)
        ->join('movies', 'movies.m_id', '=', 'watch_history.m_id')
        ->join('users', 'users.id', '=', 'watch_history.u_id')
        ->where('watch_history.u_id', '=', $userId)
        ->get()->toArray();
    }

    public function getHistoryByUserIdAndMovieId($userId, $movieId){
        return DB::table($this->table)->where('u_id', $userId)->where('m_id', $movieId)->first();
    }

    public function insert($userId, $movieId, $e_Episode){
        $wh = [
            'u_id' => $userId,
            'm_id' => $movieId,
            'wh_e_Episode' => $e_Episode
        ];
        return DB::table($this->table)->insert($wh);
    }

    public function updateTimestamp($userId, $movieId, $e_Episode){
        return DB::table($this->table)->where('u_id', $userId)->where('m_id', $movieId)->update([
            'wh_e_Episode' => $e_Episode,
            'wh_Timestamp'=> Carbon::now('Asia/Ho_Chi_Minh')
        ]);
    }

    public function deleteHistory($userId, $movieId){
        return DB::table($this->table)->where('u_id', $userId)->where('m_id', $movieId)->delete();
    }

    public function deleteAllHistoryByUserId($userId){
        return DB::table($this->table)->where('u_id', $userId)->delete();
    }
}
