<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Episode;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follow';
    protected $episode;

    public function __construct(){

        $this->episode = new Episode();
        
    }

    public function insertFollow($userId, $movieId){
        $follow = [
            'u_id' => $userId,
            'm_id' => $movieId
        ];
        return DB::table($this->table)->insert($follow);
    }

    public function deleteFollow($userId, $movieId){
        return DB::table($this->table)->where('u_id', $userId)->where('m_id', $movieId)->delete();
    }

    public function getFollow($userId, $movieId){
        return DB::table($this->table)->where('u_id', $userId)->where('m_id', $movieId)->first();
    }

    public function getFollowByUserId($userId){
        return DB::table($this->table)
        ->join('movies', 'movies.m_id', '=', 'follow.m_id')
        ->join('users', 'users.id', '=', 'follow.u_id')
        ->where('follow.u_id', '=', $userId)
        ->get()->toArray();

    }

    public function getMovieMaxFollow($movieId = null){
        if(isset($movieId)){
            $query = '(SELECT m.*
            FROM movies m
            JOIN (
                SELECT m_id
                FROM `follow`
                GROUP BY m_id
                ORDER BY COUNT(*) DESC
                LIMIT 7
            ) f ON m.m_id = f.m_id) 
            except (
                SELECT * 
                FROM movies 
                where m_id = '.$movieId.')';
        }else{
            $query = '(SELECT m.*
            FROM movies m
            JOIN (
                SELECT m_id
                FROM `follow`
                GROUP BY m_id
                ORDER BY COUNT(*) DESC
                LIMIT 7
            ) f ON m.m_id = f.m_id)';
        }
        $movieMaxFollow = DB::select($query);
        if(!empty($movieMaxFollow)){
            for($i = 0; $i < count($movieMaxFollow); $i++){
                $episodeNewByMovieId = $this->episode->getEpisodeNewByMovieId($movieMaxFollow[$i]->m_id);
                if(!empty($episodeNewByMovieId)){
                    $movieMaxFollow[$i]->episodeNew = $episodeNewByMovieId->e_Episode;
                }else{
                    $movieMaxFollow[$i]->episodeNew = "Sắp công chiếu";
                }
                
            }
        }
        return $movieMaxFollow;
    }
}
