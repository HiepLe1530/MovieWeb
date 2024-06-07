<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Episode extends Model
{
    use HasFactory;
    protected $table = 'episodes';
    protected $primaryKey = 'id';
    public function getEpisodeByMovieId($movieId){
        return DB::select('select * from episodes where e_m_id = "'.$movieId.'"');
        
    }

    public function getEpisodeNewByMovieId($movieId){
        return DB::table($this->table)->select('e_Episode')->where('e_m_id', $movieId)->orderBy('id', 'DESC')->first();
    }
    
    public function insertEpisode($episodes){
        return DB::table($this->table)->insert($episodes);
    } 

    public function getEpisodeById($episodeId){
        return DB::table($this->table)->where('id', $episodeId)->first();
    }

    public function updateEpisode($episodes, $episodeId){
        return DB::table($this->table)->where('id', $episodeId)->update($episodes);
    }

    public function deleteEpisode($episodeId){
        return DB::table($this->table)->where('id', $episodeId)->delete();
    }

    public function getOneEpisodeByMovieId($movieId, $e_Episode){
        return DB::table($this->table)->where('e_m_id', $movieId)->where('e_Episode','=', $e_Episode)->first();
    }

    public function getEpisodeByMovieIdAndEpisode($episode, $movieId){
        return DB::table($this->table)
        ->join('movies', 'm_id', '=', 'e_m_id')
        ->where('e_m_id', $movieId)
        ->where('e_Episode','like', '%'.$episode.'%')
        ->get()
        ->toArray();
    }
}
