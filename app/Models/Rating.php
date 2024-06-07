<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';

    public function getRatingAvg($movieId){
        $ratingAvg = DB::table($this->table)->where('m_id', $movieId)->avg('r_Rating');
        $ratingAvg = round($ratingAvg);
        return $ratingAvg;
    }

    public function getRatingCount($movieId){
        return DB::table($this->table)->where('m_id', $movieId)->count();
    }

    public function getRatingByMovieIdAndIpAddress($movieId, $ipAddress){
        return DB::table($this->table)->where('m_id', $movieId)->where('r_IpAddress', $ipAddress)->first();
    }

    public function insertRating($rating){
        DB::table($this->table)->insert($rating);
    }

    // public function fake_rating(){
    //     for($i =11; $i <= 17; $i++){
            
    //         DB::table('rating')->insert([
    //             'm_id' => '25',
    //             'r_Rating' => '5',
    //             'r_IpAddress' => $i
    //         ]);
            
    //     }
    // }
}
