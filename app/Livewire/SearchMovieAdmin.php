<?php

namespace App\Livewire;

use App\Models\Movie;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SearchMovieAdmin extends Component
{
    protected $movie;

    public $movieName = "";
    public $directorName = "";
    public $releaseYear = 0;

    public function __construct(){

        $this->movie = new Movie();
    }

    public function render()
    {
        $movieName = $this->movieName;
        $directorName = $this->directorName;
        $releaseYear = $this->releaseYear;
        // $movies = new LengthAwarePaginator(collect([]), 0, 15, 1, [
        //     'path' => 'admin/movie',  // Cần thiết để duy trì đường dẫn phân trang chính xác
        //     'pageName' => 'page'  // Tham số trên URL để chỉ số trang
        // ]);;
        $movies = [];
        if(empty($movieName) && empty($directorName) && $releaseYear == 0){

            $movies = $this->movie->getall();
            // $movies->withPath('/admin/movie');
            
        }elseif(!empty($movieName) && !empty($directorName) && $releaseYear != 0){
            $movies = $this->movie->getMovieByMovieNameAndDirectorNameAndReleaseYear($movieName, $directorName, $releaseYear);
            // $movies->withPath('/admin/movie');
        }
        else{
            if(!empty($movieName)){
                if(!empty($directorName)){
                    $movies = $this->movie->getMovieByMovieNameAndDirectorName($movieName, $directorName);
                }
                elseif($releaseYear != 0){
                    $movies = $this->movie->getMovieByMovieNameAndReleaseYear($movieName, $releaseYear);
                }else{
                    $movies = $this->movie->getMovieByMovieName($movieName);
                }
            }elseif(!empty($directorName)){
                if($releaseYear != 0){
                    $movies = $this->movie->getMovieByDirectorNameAndReleaseYear($directorName, $releaseYear);
                }else{
                    $movies = $this->movie->getMovieByDirectorName($directorName);
                }
            }elseif($releaseYear != 0){
                $movies = $this->movie->getMovieByReleaseYear($releaseYear);
            }
        }

        $norecord = 'Hiện tại chưa có bộ phim nào được quản lý!';
        $currentYear = Carbon::now()->year;
        return view('livewire.search-movie-admin', compact('movies', 'norecord', 'currentYear'));
    }
}
