<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Genre extends Model
{
    use HasFactory;
    protected $table = 'genres';

    public function getCountGenre(){
        return DB::table($this->table)->count();
    }

    public function getall(){
        // return DB::select('select m_Image, m_Title, m_Director, m_ReleaseYear, m_Description from movies')->paginate(1);
        return DB::table($this->table)->get()->toArray();
        
    }
    public function insertGenre($genres){
        return DB::table($this->table)->insert($genres);
    }

    public function getGenreById($id){
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function updateGenre($genres, $id){
        return DB::table($this->table)->where('id', $id)->update($genres);
    }

    public function deleteGenre($id){
        DB::table('genre_has_movie')->where('g_id', $id)->delete();
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
